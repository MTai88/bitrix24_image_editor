### Use bitrix24 landing image editor in your own components

### Usage

- Copy `/local/` directory to your project
- Add extension to your page

```
use \Bitrix\Main\UI\Extension;

Extension::load('mtai.image_editor');
```

- use image editor class to your html image element

```
    const editor = new BX.Mtai.ImageEditor(document.getElementById("image_to_edit"));
    editor.edit()
        .then((file) => {
            editor.updateElement(); // apply changes to the current image
        
            // send blob file via ajax request to save changes
            // ...            
        });
```

- see an example usage in `/example/index.php`

### Notes

If you need to add your changes to code, then you need to
install [bitrix cli](https://dev.1c-bitrix.ru/learning/course/index.php?COURSE_ID=43&LESSON_ID=12435) and rebuild
extension using `bitrix build` 