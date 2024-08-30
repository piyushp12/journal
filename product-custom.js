jQuery(document).ready(function ($) {
    $("#customiseSelect").change(function (event) {
        const selectedValue = $(this).val();
        if (selectedValue === "No") {
            $("#personaliseCover").css('display', 'none')
            $("#moreCustoms").css('display', 'none')
            $("#personaliseInner").css('display', 'none')
        }
        else {
            $("#personaliseCover").css('display', 'block')
            $("#moreCustoms").css('display', 'block')
            $("#personaliseInner").css('display', 'block')
        }
    });

    $("#pageSelection").change(function (event) {
        const selectedValue = $(this).val();
        if (selectedValue !== "non") {
            $(".logoText").css('display', 'block');
        }
        else {
            $(".logoText").css('display', 'none');
        }
    });
    $("#selectionText").change(function (event) {
        const selectedValue = $(this).val();
        if (selectedValue === "uploadlogo") {
            $(".uploadInnerLogo").css('display', 'block');
            $(".writeText").css('display', 'none');

        }
        else {
            $(".writeText").css('display', 'block');
            $(".uploadInnerLogo").css('display', 'none');
        }
    });

    uploadInnerLogo

    // $("#personaliseProd").change(function (event) {
    //     const selectedValue = $(this).val();
    //     if (selectedValue === "Name or initial") {
    //         $("#uploadImage").hide();
    //         $("#textInput").hide();
    //         $("#textInput2").hide();
    //         $("#textInput3").hide();
    //         $("#writingArea").show();
    //     } else if (selectedValue === "Phrase") {
    //         $("#writingArea").hide();
    //         $("#uploadImage").hide();
    //         $("#textInput").show();
    //         $("#textInput2").show();
    //         $("#textInput3").show();
    //     } else {
    //         $("#writingArea").hide();
    //         $("#textInput").hide();
    //         $("#textInput2").hide();
    //         $("#textInput3").hide();
    //         $("#uploadImage").show();
    //     }
    // });

    $('#uploadImage label').click(function () {
        $('#logoUpload').click();
    });

    $('#uploadImageInner label').click(function () {
        $('#logoUploadInner').click();
    });

    $('#uploadInnerLogo label').click(function () {
        $('#logoUploadIn').click();
    });


    document.getElementById("personaliseProd").addEventListener("change", function () {
        const selectedOption = this.value;
        const textInputs = document.querySelectorAll("#textInput, #textInput2, #textInput3");
        const textarea = document.getElementById("writingArea");
        const fileUploadDiv = document.getElementById("uploadImage");
        const insidewrite = document.getElementById("insideWrite")

        // Hide all input elements initially
        textInputs.forEach(input => input.style.display = 'none');
        textarea.style.display = 'none';
        fileUploadDiv.style.display = 'none';

        // Show elements based on the selected option
        if (selectedOption === "Phrase") {
            textInputs.forEach(input => input.style.display = 'block');
        } else if (selectedOption === "Name or initial") {
            textarea.style.display = 'block';
        } else if (selectedOption === "Upload a logo") {
            fileUploadDiv.style.display = 'block';
        }
    });
    document.getElementById('logoUpload').addEventListener('change', function (event) {
        const reader = new FileReader();
        const file = event.target.files[0];

        reader.onload = function (e) {
            const preview = document.getElementById('logoPreview');
            preview.src = e.target.result;
            preview.style.display = 'block';

            // Optionally, store the base64 string in a hidden input field
            document.getElementById('logoDataUrl').value = e.target.result;
        };

        if (file) {
            reader.readAsDataURL(file);
        }
    });


    // document.getElementById("logoUpload").addEventListener("change", function (event) {
    //     const file = event.target.files[0];
    //     if (file) {
    //         const reader = new FileReader();
    //         reader.onload = function (e) {
    //             const logoImage = new Image();
    //             logoImage.src = e.target.result;
    //             logoImage.onload = function () {
    //                 // Store the logo image and its dimensions
    //                 window.logoImage = logoImage;
    //                 window.logoWidth = logoImage.width;
    //                 window.logoHeight = logoImage.height;
    //                 drawTextAndLogo();
    //             };
    //         };
    //         reader.readAsDataURL(file);
    //     }
    // });

    document.getElementById("customiseSelect").addEventListener("change", function () {
        const selectedValue = this.value;

        if (selectedValue === "Yes") {
            // Set the rect1 radio button as checked
            document.getElementById("rect1").checked = true;
        } else if (selectedValue === "No") {
            // Uncheck all shape radio buttons
            $("input[name='shapeSelect']").prop("checked", false);
        }
        // Optionally, you can trigger a change event if you want to run any associated functions
        $("#rect1").change();
    });

    // document.addEventListener('DOMContentLoaded', function () {
    //     var accordionToggle = document.querySelector('.accordion-toggle');
    //     var accordionContent = document.querySelector('.accordion-content');

    //     accordionToggle.addEventListener('click', function () {
    //         var contentStyle = accordionContent.style.display;

    //         if (contentStyle === 'none' || contentStyle === '') {
    //             accordionContent.style.display = 'block';
    //         } else {
    //             accordionContent.style.display = 'none';
    //         }
    //     });
    // });

    $('.accordion-toggle').click(function () {
        $('.accordion-content').slideToggle();
    });

    $('.accordion-toggle-inner').click(function () {
        $('.accordion-content-inner').slideToggle();
    });

    $('#popupOpen').click(function () {
        $('#popup').css("display", "block");
    });

    $('#closePopup').click(function () {
        $('#popup').css("display", "none");
    });

    $('#personaliseInner').click(function () {
        $('.save-btn').css("display", "block");
    });


    $('#uploadMyDesign').click(function () {
        $('#showUploadDesign').css("display", "block");
        $('#popup').css("display", "none");
    });


});



