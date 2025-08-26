export function InitDropZone2(selector, userConfig = {}) {
    const defaultConfig = {
        inputName: "images[]",
        acceptedFiles: null,
        message: "Glissez et déposez des images ici",
        removedInputId: null,
        existingFiles: [],
        maxFiles: Infinity,
        addHidden: false,
        displayOnly: false,
        url: "/file-upload",
    };

    Dropzone.autoDiscover = false;
    const config = Object.assign({}, defaultConfig, userConfig);

    if (config.maxFiles === 1) {
        config.inputName = config.inputName.replace(/\[\]$/, "");
    }

    const dropzoneElements = document.querySelectorAll(selector);

    dropzoneElements.forEach((dropzoneElement) => {
        if (Dropzone.instances.some((dz) => dz.element === dropzoneElement)) {
            return;
        }

        if (config.displayOnly) {
            dropzoneElement.classList.add("dropzone-display-only");
        }

        const dropzoneOptions = {
            url: config.url,
            paramName: config.inputName,
            acceptedFiles: config.acceptedFiles,
            dictDefaultMessage: config.displayOnly ? "" : config.message,
            autoProcessQueue: config.autoProcessQueue ?? false,
            addRemoveLinks: !config.displayOnly,
            clickable: !config.displayOnly,
            autoDiscover: false,
            dictRemoveFile: config.dictRemoveFile ?? "Retirer",
            ...config,
        };

        const myDropzone = new Dropzone(dropzoneElement, dropzoneOptions);

        myDropzone.on("addedfile", function (file) {
            updateHiddenInput(this);
            if (this.files.length > config.maxFiles) {
                const index = this.files.length - 2;
                if (index >= 0) {
                    this.removeFile(this.files[index]);
                }
            }
        });

        myDropzone.on("removedfile", function (file) {
            if (!file.upload) {
                const removedFileInput = document.createElement("input");
                removedFileInput.type = "hidden";
                removedFileInput.name = "removed_" + config.inputName;
                removedFileInput.value = file.path ?? file.dataURL;
                dropzoneElement.appendChild(removedFileInput);
            }
            updateHiddenInput(this);
        });

        const files = Array.isArray(config.existingFiles)
            ? config.existingFiles
            : [config.existingFiles];
        files.forEach((item) => {
            if (!item || !item.size || item.size <= 0) return;
            const mockFile = {
                name: item.nom,
                size: item.size,
                path: item.path,
            };
            myDropzone.files.push(mockFile);
            myDropzone.displayExistingFile(mockFile, item.url, null, null);
            setTimeout(() => {
                dropzoneElement
                    .querySelectorAll(".dz-filename")
                    .forEach((nameElement) => {
                        if (!mockFile.name) nameElement.style.display = "none";
                    });

                dropzoneElement
                    .querySelectorAll(".dz-size")
                    .forEach((sizeElement) => {
                        if (!mockFile.size) sizeElement.style.display = "none";
                    });
            }, 100);
        });

        if (config.addHidden && !config.displayOnly) {
            const hiddenFilesInput = createHiddenInput(
                config.inputName,
                "file"
            );
            dropzoneElement.appendChild(hiddenFilesInput);
        }

        function updateHiddenInput(dropzone) {
            const input = dropzone.element.querySelector('input[type="file"]');
            if (!input) return;

            const dataTransfer = new DataTransfer();
            dropzone.files.forEach((file) => {
                if (file instanceof File) {
                    dataTransfer.items.add(file);
                }
            });

            input.files = dataTransfer.files;
        }

        function createHiddenInput(name, type) {
            const input = document.createElement("input");
            input.type = type;
            input.name = name;
            input.id = name.replace(/\[\]$/, "");
            if (
                type === "file" &&
                (config.maxFiles === Infinity || config.maxFiles > 1)
            ) {
                input.multiple = true;
            }
            input.style.display = "none";
            return input;
        }
    });
}
