import 'landing.imageeditor';

/**
 * Wrapper around the Bitrix24 "Sites" (landing) image editor
 * for use in your own components.
 *
 * @memberOf BX.Mtai
 */
export class ImageEditor
{
	/**
	 * @param {HTMLImageElement} image
	 */
	constructor(image)
	{
		this.image = image;
		this.file = null;
		this.objectUrl = null;
	}

	/**
	 * Opens the image editor for the element passed to the constructor.
	 *
	 * @returns {Promise<File|null>} edited file or null when the editor was closed without saving
	 */
	async edit()
	{
		this.file = await ImageEditor.openEditor({
			image: this.image.src,
			width: this.image.naturalWidth,
			height: this.image.naturalHeight,
		});

		return this.file;
	}

	/**
	 * Applies the result of the last edit() call to the source image element.
	 */
	updateElement()
	{
		if (!this.file)
		{
			return;
		}

		if (this.objectUrl)
		{
			URL.revokeObjectURL(this.objectUrl);
		}

		this.objectUrl = URL.createObjectURL(this.file);
		this.image.src = this.objectUrl;
	}

	/**
	 * Opens BX.Landing.ImageEditor and resolves with the edited file.
	 *
	 * The stock editor promise never settles when the editor is closed
	 * without exporting, so it is raced with the editor close event:
	 * on cancel the wrapper resolves with null instead of hanging forever.
	 *
	 * @param {{image: string, width: number, height: number}} params
	 * @returns {Promise<File|null>}
	 * @private
	 */
	static openEditor({ image, width, height })
	{
		return new Promise((resolve) => {
			let settled = false;
			const finish = (result) => {
				if (settled)
				{
					return;
				}

				settled = true;
				BX.removeCustomEvent('BX.Main.ImageEditor:close', onEditorClose);
				resolve(result);
			};

			// The close event also fires right after a successful export,
			// but the edit promise settles first (microtask vs timer),
			// so the file wins the race.
			const onEditorClose = () => {
				setTimeout(() => finish(null), 0);
			};

			BX.addCustomEvent('BX.Main.ImageEditor:close', onEditorClose);

			BX.Landing.ImageEditor
				.edit({
					image,
					dimensions: { width, height },
				})
				.then(finish, finish);
		});
	}
}
