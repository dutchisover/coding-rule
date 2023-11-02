<!DOCTYPE html>
<?php
// テスト（本番時は必ずfalseに！）
global $dev;
$dev = false;


// SSLリダイレクト
// if (empty($_SERVER['HTTPS'])) {
// 	header("HTTP/1.1 301 Moved Permanently");
// 	header("Location: https://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}");
// 	exit;
// }





//スプレッドシートIDの指定と必要なJSONデータの取得
function ss_json($sheet_id, $sheet_name)
{
	$data = "https://sheets.googleapis.com/v4/spreadsheets/" . $sheet_id . "/values/" . $sheet_name . "?key=AIzaSyB4ku2volfiKAtNJRmO0GUjczvFoC0mqe0";
	$json = file_get_contents($data);
	$json_decode = json_decode($json);
	$posts = $json_decode->values;
	return $posts;
}

// キャッシュ
$d = "20230306";
if (!$dev) {
	$cache = '?' . $d;
} else {
	$cache = '?' . date('YmdHis');
}

?>
<html lang="ja" prefix="og: http://ogp.me/ns#">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="robots" content="noindex">
	<title>コーディングルール</title>

	<link rel="stylesheet" href="./css/prism.css">
	<link rel="stylesheet" href="./css/style.css">
</head>

<body id="body">

	<main class="main">

		<article>
			<h1>コーディング規約<span>&lt;Logic+A design & smile-media></span></h1>



			<?php
			$posts = ss_json("1wI_eKYa6dkvYlnHcbEfAn_9FPJbujV62R0iF4lH7yr8", "code");

			//データを配列で取得・格納
			$h2 = [];
			$h3 = [];
			$h4 = [];
			$content = [];
			$lang = [];
			$code = [];

			// 更新日取得
			echo '<time>最終更新日　' . $posts[0][6] . '</time>';

			foreach ($posts as $post) {
				$h2[] = $post[0];
				$h3[] = $post[1];
				$h4[] = $post[2];
				$content[] = $post[3];
				$lang[] = $post[4];
				$code[] = $post[5];
			}

			//取得したJSONデータをソースコードに出力する
			for ($i = 1; $i < count($content); $i++) {
				// echo '<section id="anc-' . $i . '">';

				if ($h2[$i]) {
					echo '<h2 id="anc-h2-' . $i . '">' . $h2[$i] . '</h2>';
				}
				if ($h3[$i]) {
					echo '<h3 id="anc-h3-' . $i . '">' . $h3[$i] . '</h3>';
				}
				if ($h4[$i]) {
					echo '<h4>' . $h4[$i] . '</h4>';
				}
				if ($content[$i]) {
					echo '<div class="content">' . $content[$i] . '</div>';
				}
				if (!$lang[$i]) {
					$lang[$i] = "html";
				}
				if ($code[$i]) {
					$syntax = str_replace("<", "&lt;", $code[$i]);
					echo '<pre><code class="language-' . $lang[$i] . '">' . $syntax . '</code></pre>';
				}

				// echo '</section>';
			}
			?>

		</article>

	</main>

	<aside class="sidebar">
		<ul>
			<?php
			//取得したJSONデータをソースコードに出力する
			for ($i = 1; $i < count($content); $i++) {
				if ($h2[$i]) {
					echo '<li><a href="#anc-h2-' . $i . '">' . $h2[$i] . '</a></li>';
				}
				if ($h3[$i]) {
					echo '<ul><li><a href="#anc-h3-' . $i . '">' . $h3[$i] . '</a></li></ul>';
				}
			}
			?>
		</ul>
	</aside>


	<script src="./js/prism.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
	<script src="./js/script.js"></script>
</body>

</html>
