export function InitDropZone(
    dropZoneId,
    url,
    inputName = 'images[]',
    rules,
    addInputId = null,
    message = 'Glissez et déposez des images ici',
    removedInputId = null,
    existingFiles = [],
    maxFile = Infinity,
) {
    const dropzoneElement = document.getElementById(dropZoneId);
    if (!dropzoneElement) {
        return;
    }

    if (Dropzone.instances.some(dz => dz.element === dropzoneElement)) {
        // console.log('Dropzone already initialized');
        return; 
    }

    Dropzone.autoDiscover = false;
    const myDropzone = new Dropzone(`#${dropZoneId}`, {
        url: url,
        paramName: inputName,
        maxFile: maxFile,
        maxFilesize: 2, // Max file size (en Mo)
        acceptedFiles: rules,
        dictDefaultMessage: message,
        dictRemoveFile: "Retirer",
        autoProcessQueue: false, // disable auto send on file added
        addRemoveLinks: true, // add remove links
        autoDiscover: false,
        init: function () {
            const files = Array.isArray(existingFiles) ? existingFiles : [existingFiles];
            files.forEach((item) => {
                if (item.size <= 0) {
                    return;
                }
                const mockFile = {
                    name: item.nom,
                    size: item.size,
                    path: item.path,
                };
                this.displayExistingFile(mockFile, item.url, null, null);
            });

            this.on("addedfile", function (file) {
                if (addInputId) {
                    updateHiddenInput(this, addInputId);
                }
            });

            this.on("removedfile", function (file) {
                if (removedInputId) {
                    const removedFilesInput = document.getElementById(removedInputId);
                    if (removedFilesInput) {
                        const currentFiles = removedFilesInput.value ? JSON.parse(removedFilesInput.value) : [];
                        if (file.path) {
                            currentFiles.push(file.path);
                        } else {
                            currentFiles.push(file.name);
                        }
                        removedFilesInput.value = JSON.stringify(currentFiles);
                    }
                }
                if (addInputId) {
                    updateHiddenInput(this, addInputId);
                }
            });
        },
    });

    function updateHiddenInput(dropzone, hiddenInputId) {
        const input = document.getElementById(hiddenInputId);
        if (!input) {
            return;
        }
        const dataTransfer = new DataTransfer();
        dropzone.files.forEach((file) => {
            if (file instanceof File) {
                dataTransfer.items.add(file);
            }
        });
        input.files = dataTransfer.files;
    }
}
