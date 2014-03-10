<?php

namespace Rida\Controller;

class RidaController extends \PublicController
{
	/**
	 * Default Index Method for Rida
	 * Every reqest for rida is make in there
	 *
	 * @return void
	 */
	public function index()
	{
		$file = $this->param('file');

		$title = \Config::get('rida::rida.title');

		try {
			$navigation = get_tree(DOCS_PATH);
		} catch (\Reborn\Exception\DirectoryNotFoundException $e) {
			$message = \Config::get('rida::rida.message');
			$this->template->message = str_replace('{{title}}', $title, $message);
			$this->template->setPartial('comingsoon');

			return $this->template->render();
		}

		$current = ltrim(str_replace(rtrim(url('docs'), '/'), '', \Uri::current()), '/');

		$navigation = tree_sorting($navigation);

		$page = get_page($navigation, $current, \Module::get('Rida', 'uri'));

		$not_found = false;

		if (empty($page)) {
			$not_found = true;
		}

		if ($this->request->isAjax()) {
			$return = array('data' => $page, 'status' => 'found');

			if ($not_found) {
				$return['status'] = 'notFound';
			}

			return $this->json($return);
		}

		if ($not_found) return $this->notFound();

		$this->template->doc_title = $title;

		$this->template->github = \Config::get('rida::rida.github');
		$this->template->twitter = \Config::get('rida::rida.twitter');

		$this->template->title($title)
						->style('rida.css', 'Rida')
						->script('prettify.js', 'Rida')
						->setPartial('index', compact('page', 'navigation'));
	}
}
