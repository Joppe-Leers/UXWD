document.getElementById("takePictureButton").onclick = function selectFile() {
    document.getElementById("inputFile").click();
}

function getUploadedPicture(input) {
    if (input.files && input.files[0]) {
        let reader = new FileReader();

        reader.onload = function (e) {
            document.getElementById("backupIcon").style.display = 'none';
            document.getElementById("noFileText").style.display = 'none';
            document.getElementById("previewImageDiv").style.display = 'flex';
            $('#uploadImageTag').attr('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }
}
