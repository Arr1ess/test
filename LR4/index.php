<?php include '../defolt/header.php'; ?>

<main class="main-container">
	<form class="form" method="post">
		<!-- <textarea name="htmlCode" id="htmlCode" class="form__textarea" rows="10" cols="50"></textarea><br> -->
		<textarea name="htmlCode" id="htmlCode" class="form__textarea" rows="10"
			cols="50"><?php echo isset($_POST['htmlCode']) ? htmlspecialchars($_POST['htmlCode']) : ''; ?></textarea>

		<input type="submit" value="Отправить" class="form__submit">
	</form>

	<?php
	
	function processText($text)
	{
		return htmlspecialchars($text);
	}

	function displayProcessedText($text)
	{
		echo "<div class='processed-text'>" . $text . "</div>";
	}

	function task1($inputHtml)
	{
		$processedText = processText($inputHtml);
		displayProcessedText($processedText);
	}

	function task2($text)
	{
		$text = preg_replace('/([!]){4,}/', '!!!', $text);
		$text = preg_replace('/([.]){4,}/', '...', $text);
		$text = preg_replace('/([?]){4,}/', '???', $text);
		$text = preg_replace('/(?<!\!)(\!){2}(?!\!)/', '!', $text);
		$text = preg_replace('/(?<!\.)\.{2}(?!\.)/', '.', $text);
		$text = preg_replace('/(?<!\?)\?{2}(?!\?)/', '?', $text);
		$text = preg_replace('/([^\p{L}\p{N}\s!?.])\1+/', '$1', $text);
		displayProcessedText($text);
	}

	function task3($text)
	{
		$text = preg_replace('/\b(\w+)(\s+)((\1\s+)+)/', '$1 <span class="highlight">$3</span>', $text);
		displayProcessedText($text);
	}

	function generateTableOfContents($text)
	{
		preg_match_all('/<h([1-3])>(.*?)<\/h\1>/', $text, $matches, PREG_SET_ORDER);

		$tableOfContents = '<ul>';
		foreach ($matches as $match) {
			$level = $match[1];
			$title = $match[2];
			$anchor = preg_replace('/\W+/', '-', strtolower($title));
			$shortTitle = (strlen($title) > 50) ? substr($title, 0, 50) . '...' : $title;
			$tableOfContents .= "<li><a href='#$anchor'>$shortTitle</a></li>";
			$text = str_replace($match[0], "<h$level id='$anchor'>$title</h$level>", $text);
		}
		$tableOfContents .= '</ul>';

		return ['tableOfContents' => $tableOfContents, 'text' => $text];
	}

	function addAnchorsToHeadings($text)
	{
		return preg_replace('/<h([1-3])>(.*?)<\/h\1>/', '<h$1 id="$2">$3</h$1>', $text);
	}

	function extractBodyContent($html)
	{
		preg_match('/<body[^>]*>(.*?)<\/body>/is', $html, $matches);

		if (!empty($matches)) {
			$bodyContent = $matches[1];
			return $bodyContent;
		} else {
			return '';
		}
	}

	function task4($inputHtml)
	{
		$processedData = generateTableOfContents($inputHtml);
		$tableOfContents = $processedData['tableOfContents'];
		$processedText = $processedData['text'];
		$processedTextWithAnchors = addAnchorsToHeadings($processedText);

		displayProcessedText($tableOfContents . $processedTextWithAnchors);
	}
	

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$inputHtml = $_POST['htmlCode'] ?? '';
		$inputHtml = extractBodyContent($inputHtml);
		task1($inputHtml);
		task2($inputHtml);
		task3($inputHtml);
		task4($inputHtml);
	}
	?>
</main>


<?php include '../defolt/footer.php'; ?>