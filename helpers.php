<?php

/**
 * Change Filename to Title String
 *
 * @param string $filename
 * @return string
 */
function change_title($filename) {

	$file = str_replace('.md', '', $filename);

	$file = ltrim(preg_replace('/((\d*))/', '', $file), '_');

	return \Str::title($file);
}

/**
 * Change Filename to Url String
 *
 * @param string $filename
 * @return string
 */
function change_url($filename) {

	$file = str_replace('.md', '', $filename);

	$file = preg_replace('/((\d*)_)/', '', $file);

	return $file;
}

/**
 * Get docs file data with tree
 *
 * @param string $path Docs Folder path
 * @return array
 */
function get_tree($path = null)
{
	$path = is_null($path) ? __DIR__ : rtrim($path, DS).DS;

    if (! is_dir($path) ) {
        throw new \Reborn\Exception\DirectoryNotFoundException($path);
    }

	$paths = new \DirectoryIterator($path);

	$tree = array();

	$skips = array('.gitignore', '.git', '.gitkeep', '.DS_Store', '__MACOSX', 'README.md', 'README');

	foreach($paths as $file) {

        if(! $file->isDot() and !in_array($file->getFilename(), $skips) ) {

        	$name = change_title($file->getFilename());

        	if ($file->isDir()) {
        		$tree[$file->getFilename()] = array(
        			'type' => 'folder',
        			'name' => $name,
        			'url' => change_url($file),
        			'tree' => get_tree($path.$file.DS)
        		);
        	} else {
        		$tree[$file->getFilename()] = array(
        			'type' => 'file',
        			'name' => $name,
        			'url' => change_url($file),
        			'path' => $file->getPath().DS.$file->getFilename()
        		);
        	}
        }
    }

    sort($tree);

	return $tree;
}

/**
 * Get navigation Links
 *
 * @param array $tree Tree data array
 * @param string $tag Nav tag name
 * @param string $url_prefix Url Prefix for docs (Module Uri)
 * @return string
 */
function get_nav($tree, $tag = 'ul', $url_prefix = 'docs')
{
	$o = '<'.$tag.'>';

	$url = url($url_prefix).'/';

	foreach ($tree as $c) {

		if (\Uri::current() == $url.$c['url']) {
			$o .='<li class="active current">';
		} else {
			$o .='<li class="'.$c['type'].'">';
		}

		$href = ($c['type'] == 'folder') ? '' : $url . $c['url'];

		if ($href) {
			$o .= '<a href="'. $href .'" >'.$c['name'].'</a>';
		} else {
			$o .= '<span>'.$c['name'].'</span>';
		}

		if (isset($c['tree'])) {
			$o .= get_nav($c['tree'], $tag);
		}

		$o .= '</li>';
	}

	$o .= '</'.$tag.'>';

	return $o;
}

/**
 * Get page contnt data
 *
 * @param string $filename
 * @return string
 */
function get_page($tree, $current, $child_loop = false) {

	$page = array();

	$cache_name = ($current == '') ? 'index' : str_replace('/', '_', $current);

	$cache_name = 'Rida::'.$cache_name;

	if (\Cache::has($cache_name)) {
		$data = \Cache::get($cache_name);

		if (!empty($data) && ($data['last_modefied'] >= filemtime($data['path'])) ) {
			return $data;
		}
	}

	if ($current == '' and $child_loop !== true) {
		$path = DOCS_PATH.\Config::get('rida::rida.index_page', 'index.md');

		if (!is_file($path)) {
			return array();
		}

		$page = array(
			'name' => 'index',
			'path' => $path,
			'last_modefied' => filemtime($path),
			'content' => markdown_extra(file_get_contents($path))
		);
	}

	foreach ($tree as $node) {
		if ($node['type'] == 'file') {
			if ($node['url'] == $current) {
				$page['name'] = $node['name'];
				$page['path'] = $node['path'];
				$page['last_modefied'] = filemtime($node['path']);
				$page['content'] = markdown_extra(file_get_contents($node['path']));

				break;
			}
		} else {
			$result = get_page($node['tree'], $current, true);

			if (!empty($result)) {
				$page = $result;
				break;
			}
		}
	}

	\Cache::set($cache_name, $page);

	return $page;
}
