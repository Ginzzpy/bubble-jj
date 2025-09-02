<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

if (!function_exists('spaRender')) {
  function spaRender(Request $request, string $content, array $data = [])
  {
    if ($request->ajax()) {
      /** @var \Illuminate\View\View $view */
      $view = View::make($content);
      $sections = $view->renderSections();

      return response()->json([
        'title' => $sections['title'] ?? '',
        'styles'  => $sections['styles'] ?? '',
        'content' => $sections['content'] ?? '',
        'scripts' => $sections['scripts'] ?? '',
      ]);
    } else {
      return view($content, $data);
    }
  }
}
