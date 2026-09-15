<?php
require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php');

use Bitrix\Main\UI\Extension;

$APPLICATION->SetTitle('Редактор изображений Bitrix24 (из модуля «Сайты»)');
Extension::load([
	'ui.bootstrap4',
	'mtai.image_editor',
]);
?>
<div class="container mt-4">
	<h2>Редактор изображений <code>mtai.image_editor</code></h2>

	<p>
		Обёртка над штатным редактором изображений модуля «Сайты»
		(<code>landing.imageeditor</code> → PhotoEditorSDK). Кликните «Редактировать»,
		примените фильтр/кадрирование и нажмите галочку — файл вернётся в браузер
		как <code>File</code>, картинка обновится без перезагрузки страницы.
	</p>

	<div class="row">
		<div class="col-md-8">
			<div class="card">
				<img class="card-img-top" id="image_to_edit" src="./image.jpg" alt="Image to edit">
				<div class="card-body">
					<h5 class="card-title">Изображение</h5>
					<a href="#" id="edit_button" class="btn btn-primary">Редактировать</a>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">Результат</h5>
					<dl id="file_info" class="mb-0">
						<dt>Файл ещё не редактировался</dt>
					</dl>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	document.getElementById('edit_button').addEventListener('click', async (event) => {
		event.preventDefault();

		const imageElement = document.getElementById('image_to_edit');
		const editor = new BX.Mtai.ImageEditor(imageElement);

		const file = await editor.edit();
		if (!file)
		{
			// пользователь закрыл редактор без сохранения
			return;
		}

		// file — готовый File (Blob): его можно отправить на сервер
		// через FormData или сразу применить к элементу:
		editor.updateElement();

		document.getElementById('file_info').innerHTML = `
			<dt>Имя</dt><dd>${BX.util.htmlspecialchars(file.name)}</dd>
			<dt>Тип</dt><dd>${BX.util.htmlspecialchars(file.type)}</dd>
			<dt>Размер</dt><dd>${(file.size / 1024).toFixed(1)} КБ</dd>
		`;

		// пример отправки на сервер:
		//
		// const data = new FormData();
		// data.append('ACTION', 'uploadUpdatedImage');
		// data.append('data', file);
		// fetch(location.href, {method: 'POST', body: data})
		// 	.then((response) => response.json())
		// 	.then((result) => { imageElement.src = result.url; });
	});
</script>
<?php require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php'); ?>
