<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

use Bitrix\Main\UI\Extension;

?><?php
Extension::load([
    'ui.bootstrap4',
    'mtai.image_editor'
]);
?>
<div class="card">
    <img class="card-img-top" id="image_to_edit" src="./image.jpg" alt="Image to edit">
    <div class="card-body">
        <h5 class="card-title">Image editor</h5>
        <a href="#" onclick="editImage();" class="btn btn-primary">Edit</a>
    </div>
</div>
<script>
    function editImage() {
        const imageElement = document.getElementById("image_to_edit");
        const editor = new BX.Mtai.ImageEditor(imageElement);
        editor.edit()
            .then((file) => {
                // send blob file via ajax request to save changes
                /*
                const data = new FormData();
                data.append('IS_AJAX_ACTION', 'Y');
                data.append('ACTION', 'uploadUpdatedImage');
                data.append('flink', imageElement.src);
                data.append('data', file);
                $.ajax({
                    type: 'POST',
                    data,
                    processData: false,
                    contentType: false
                }).done(function(data) {
                    if(data.success){
                        imageElement.src = data.url;
                    }
                }.bind(this));
                */


                editor.updateElement(); // apply changes to the current image
            });
    }
</script>
<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
