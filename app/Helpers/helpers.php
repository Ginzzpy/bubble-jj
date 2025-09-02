<?php

use Illuminate\Http\Request;

if (!function_exists('spaRender')) {
  function spaRender(Request $request, string $title, string $layout, string $view, array $data = [])
  {
    if ($request->ajax()) {
      return response()->json([
        'title' => $title,
        'content' => view($view, $data)->render()
      ]);
    } else {
      $data['view'] = $view;
      $data['title'] = $title;
      return view($layout, $data);
    }
  }
}
