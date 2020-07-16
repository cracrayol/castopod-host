<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Castopod Auth</title>
	<meta name="description" content="Castopod is an open-source hosting platform made for podcasters who want engage and interact with their audience.">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" type="image/png" href="/favicon.ico" />
	<link rel="stylesheet" href="/index.css">
</head>

<body class="flex flex-col items-center justify-center min-h-screen mx-auto bg-gray-100">
	<header class="mb-4">
		<a href="<?= route_to('home') ?>" class="text-2xl"><?= $this->renderSection(
    'title'
) ?></a>
	</header>
	<main class="w-full max-w-md px-6 py-4 mx-auto bg-white rounded-lg shadow">
		<?= view('_message_block') ?>
		<?= $this->renderSection('content') ?>
	</main>
	<footer class="flex flex-col text-sm">
		<?= $this->renderSection('footer') ?>
		<p class="py-4 border-t">
			Powered by <a class="underline hover:no-underline" href="https://castopod.org" target="_blank" rel="noreferrer noopener">Castopod</a>, a <a class="underline hover:no-underline" href="https://podlibre.org/" target="_blank" rel="noreferrer noopener">Podlibre</a> initiative.
		</p>
	</footer>
</body>