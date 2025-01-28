// Img preview
document.addEventListener("DOMContentLoaded", function () {
    const uploadContainers = document.querySelectorAll(
        ".image-upload-container"
    );

    uploadContainers.forEach((container) => {
        const uploadInput = container.querySelector(".image-upload");
        const previewContainer = container.querySelector(
            ".image-preview-container"
        );
        const previewImage = previewContainer.querySelector(".image-preview");
        const closeIcon = previewContainer.querySelector(".close-icon");
        const dragDropArea = container.querySelector(".dragDrop-area");

        // Initially hide the preview and close icon
        // previewContainer.style.display = "none";

        function handleImagePreview(file) {
            if (file) {
                const reader = new FileReader();

                reader.addEventListener("load", function () {
                    previewImage.src = reader.result;
                    previewContainer.style.display = "block";
                    closeIcon.style.display = "block";
                    container.classList.add("hide-border");
                });

                reader.readAsDataURL(file);
            }
        }

        uploadInput.addEventListener("change", function (e) {
            const file = e.target.files[0];
            handleImagePreview(file);
        });

        closeIcon.addEventListener("click", function (e) {
            e.stopPropagation(); // Prevent event from bubbling up
            uploadInput.value = "";
            previewImage.src = "";
            previewContainer.style.display = "none";
            closeIcon.style.display = "none";

            container.classList.remove("hide-border");
        });

        dragDropArea.addEventListener("dragover", function (e) {
            e.preventDefault();
            container.classList.add("dragover");
        });

        dragDropArea.addEventListener("dragleave", function (e) {
            e.preventDefault();
            container.classList.remove("dragover");
        });

        dragDropArea.addEventListener("drop", function (e) {
            e.preventDefault();
            container.classList.remove("dragover");
            const file = e.dataTransfer.files[0];
            handleImagePreview(file);
        });

        // Uncomment if needed for direct click to upload functionality
        // dragDropArea.addEventListener("click", function () {
        //     uploadInput.click();
        // });
    });
});