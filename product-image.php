<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.0.0
 */

defined('ABSPATH') || exit;

// Note: `wc_get_gallery_image_html` was added in WC 3.3.2 and did not exist prior. This check protects against theme overrides being used on older versions of WC.
if (!function_exists('wc_get_gallery_image_html')) {
    return;
}

global $product;

$columns = apply_filters('woocommerce_product_thumbnails_columns', 4);
$post_thumbnail_id = $product -> get_image_id();
$wrapper_classes = apply_filters(
    'woocommerce_single_product_image_gallery_classes',
    array(
        'woocommerce-product-gallery',
        'woocommerce-product-gallery--'. ($post_thumbnail_id ? 'with-images' : 'without-images'),
        'woocommerce-product-gallery--columns-'.absint($columns),
        'images',
    )
);




?>
    <div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ); ?>" data-columns="<?php echo esc_attr( $columns ); ?>" style="opacity: 0; transition: opacity .25s ease-in-out;">
        <div class="woocommerce-product-gallery__wrapper">
            <?php
            if ( $post_thumbnail_id ) {?>
			
			
			
			<?php
			$html = '<canvas id="canvas"></canvas>';
			
		} else {
                $wrapper_classname = $product -> is_type('variable') && !empty($product -> get_available_variations('image')) ?
                    'woocommerce-product-gallery__image woocommerce-product-gallery__image--placeholder' :
                    'woocommerce-product-gallery__image--placeholder';
            $html              = sprintf( '<div class="%s">', esc_attr( $wrapper_classname ) );

                $html             .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ), esc_html__( 'Awaiting product image', 'woocommerce' ) );
                $html             .= '</div>';
		}

            echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id ); // phpcs:disable WordPress.XSS.EscapeOutput.OutputNotEscaped

            do_action( 'woocommerce_product_thumbnails' );
		?>
        </div>

<!-- cover page canvas -->
<script>
    
    var img = "<?php echo wp_get_attachment_url( get_post_thumbnail_id($post->ID) );?>";
    var img2 = "<?php echo get_stylesheet_directory_uri() . '/resource/img/lined.jpg'; ?>";
    var img3 = "<?php echo get_stylesheet_directory_uri() . '/resource/img/non-lined.jpg'; ?>";

    const canvas = document.getElementById("canvas");
    const context = canvas.getContext("2d");
    const image = new Image();
    let scale = 1; // Zoom scale on hover
    let textX;
    let textY;
    let logoImage = new Image(); // Image for the uploaded logo
    let logoWidth = 250; // Default logo width
    let logoHeight = 100; // Default logo height
    let imageUploaded = false; // Flag to check if an image is uploaded
    const maxBackgroundWidth = 300; // Fixed width for the background shape
    const shapeHeight = 150; // Fixed height for the background shape
    let fontSize = 18; // Default font size
    let selectedFont = 'Arial'; // Default 
    

    
    function drawCanvas() {
        context.save();
        context.clearRect(0, 0, canvas.width, canvas.height);
        context.drawImage(image, 0, 0, canvas.width, canvas.height);
        drawTextAndLogo();
        context.restore();

        var canvasData = canvas.toDataURL('image/png');

        document.getElementById("canvasData").value = canvasData;
        document.getElementById("canvasPreview").src = canvasData;
        document.getElementById("canvasPreview").style.display = "block";
    }

    function drawTextAndLogo() {
        const selectValue = document.getElementById("personaliseProd").value;
        const writingArea = document.getElementById("writingArea").value;

        const textInput1 = document.getElementById("textInput").value;
        const textInput2 = document.getElementById("textInput2").value;
        const textInput3 = document.getElementById("textInput3").value;
        const innerpageText =  document.getElementById("insideWrite").value;

        const shape = document.querySelector("input[name='shapeSelect']:checked")?.id;

        const backgroundColor = document.getElementById("backColor").value;
        const textColor = document.getElementById("textColor").value;
        const selectionOption = document.getElementById("selectionText").value;
        const textPositionId = document.getElementById("textPosition").value;

        
        // Determine the selected font
        let selectedFontFamily = 'Arial'; // Default font
        const selectedFont = document.querySelector('input[name="fontStyle"]:checked')?.id;
        if (selectedFont === "Grey_Qo") {
            selectedFontFamily = "Grey_Qo"; // Use the selected font
        }else if(selectedFont === "Cedarville"){
            selectedFontFamily = "Cedarville Cursive";
        }else if(selectedFont === "Oswald"){
            selectedFontFamily = "Oswald";
        }else if(selectedFont === "montserrat"){
            selectedFontFamily = "Montserrat";
        }else if(selectedFont === "roboto"){
            selectedFontFamily = "Roboto Mono";
        }else if(selectedFont === "noto"){
            selectedFontFamily = "Noto Sans";
        }else if(selectedFont === "quitcher"){
            selectedFontFamily = "Quintessential";
        }else{
            selectedFontFamily = "Arial";
        }

        context.font = `${fontSize}px ${selectedFontFamily}`;
        context.fillStyle = textColor;

        let textLines;
        if (selectValue === "Phrase") {
            textLines = [textInput1, textInput2, textInput3].filter(line => line !== "");
        } else if (selectValue === "Name or initial") {
            textLines = [writingArea];
        } else {
            textLines = [];
        }

        const backgroundWidth = maxBackgroundWidth;
        const backgroundHeight = shapeHeight;

        const borderColor = "#fff"; // Inner border color
        const borderRadius = 10;
        const padding = 5; // Padding between the border and content

        const currentset = document.getElementById("pageSelection").value;
        if (selectionOption === "writetext") {
            if(textPositionId === "Top"){
                context.fillText(innerpageText, canvas.width/2, 25);
            }
            else if(textPositionId === "Bottom"){
                context.fillText(innerpageText, canvas.width/2, canvas.height - 25);
            }else if(textPositionId === "Top & Bottom"){
                context.fillText(innerpageText, canvas.width/2, 25);
                context.fillText(innerpageText, canvas.width/2, canvas.height - 25);
            }
            else if(textPositionId === "Top & Bottom"){
                context.fillText(innerpageText, canvas.width/2, 25);
                context.fillText(innerpageText, canvas.width/2, canvas.height - 25);
            }
            else if(textPositionId === "Topleft"){
                context.fillText(innerpageText, 120, 25);
            }
            else if(textPositionId === "Topright"){
                context.fillText(innerpageText, canvas.width - 120, 25);
            }
            else if(textPositionId === "Bottomleft"){
                context.fillText(innerpageText, 120, canvas.height - 25);
            }
            else if(textPositionId === "Bottomright"){
                context.fillText(innerpageText, canvas.width - 120, canvas.height - 25);
            }
        } 
         if (!imageUploaded && currentset === "non") {
            context.fillStyle = backgroundColor;
            context.strokeStyle = borderColor;
            context.lineWidth = 2; // Border width

            const x = (canvas.width - backgroundWidth) / 2;
            const y = (canvas.height - backgroundHeight) / 2;

            // Rectangle Shape
            if (shape === "rect1") {
                const width = backgroundWidth + padding * 2;
                const height = backgroundHeight + padding * 2;
                const startX = (canvas.width - width) / 2;
                const startY = (canvas.height - height) / 3;

                // Draw inner border with padding
                context.fillStyle = borderColor;
                context.beginPath();
                context.roundRect(startX, startY, width, height, borderRadius);
                context.fill();

                context.fillStyle = backgroundColor;
                context.beginPath();
                context.roundRect(startX + padding, startY + padding, backgroundWidth, backgroundHeight, borderRadius);
                context.fill();
                context.stroke();

                textX = startX + width / 2;
                textY = startY + height / 3 + (fontSize / 2);

            } else if (shape === "squr") {
                const width = backgroundWidth * 0.7;
                const height = backgroundWidth * 0.7;
                const startX = (canvas.width - width) / 2;
                const startY = (canvas.height - height) / 3;

                // Draw inner border with padding
                context.fillStyle = borderColor;
                context.beginPath();
                context.roundRect(startX, startY, width + padding * 2, height + padding * 2, borderRadius);
                context.fill();

                context.fillStyle = backgroundColor;
                context.beginPath();
                context.roundRect(startX + padding, startY + padding, width, height, borderRadius);
                context.fill();
                context.stroke();

                textX = startX + width / 2;
                textY = startY + height / 2 + (fontSize / 2);

                // Adjust font size to fit within the square
                let textWidth;
                do {
                    context.font = `${fontSize}px ${selectedFontFamily}`;
                    textWidth = Math.max(...textLines.map(line => context.measureText(line).width));
                    if (textWidth > width - 20 && fontSize > 5) {
                        fontSize -= 1;
                    } else {
                        break;
                    }
                } while (textWidth > width - 20);

            } else if (shape === "circle") {
                const diameter = Math.min(backgroundWidth, canvas.height / 3 * 2); // Ensuring it fits within the canvas height
                const radius = diameter / 2;
                const cx = canvas.width / 2;
                const cy = canvas.height / 3;

                // Draw inner border with padding
                context.fillStyle = borderColor;
                context.beginPath();
                context.arc(cx, cy, radius + padding, 0, 2 * Math.PI);
                context.fill();

                context.fillStyle = backgroundColor;
                context.beginPath();
                context.arc(cx, cy, radius, 0, 2 * Math.PI);
                context.fill();
                context.stroke();

                textX = cx;
                textY = cy - 20 + (fontSize / 2);

                // Adjust font size to fit within the circle
                let textWidth;
                do {
                    context.font = `${fontSize}px ${selectedFontFamily}`;
                    textWidth = Math.max(...textLines.map(line => context.measureText(line).width));
                    if (textWidth > diameter - 20 && fontSize > 5) {
                        fontSize -= 1;
                    } else {
                        break;
                    }
                } while (textWidth > diameter - 20);

            } else if (shape === "trap") {
                const width = backgroundWidth;
                const height = backgroundHeight;
                const cx = canvas.width / 2;
                const cy = canvas.height / 3;

                // Draw trapezoid with inner border and padding
                context.fillStyle = borderColor;
                context.beginPath();
                context.moveTo(cx - width / 2 - padding, cy + padding);
                context.lineTo(cx - padding, cy - height / 2 - padding);
                context.lineTo(cx + width / 2 + padding, cy + padding);
                context.lineTo(cx + padding, cy + height / 2 + padding);
                context.closePath();
                context.fill();

                context.fillStyle = backgroundColor;
                context.beginPath();
                context.moveTo(cx - width / 2, cy);
                context.lineTo(cx, cy - height / 2);
                context.lineTo(cx + width / 2, cy);
                context.lineTo(cx, cy + height / 2);
                context.closePath();
                context.fill();
                context.stroke();

                textX = cx;
                textY = cy - 20 + (fontSize / 2);

                // Adjust font size to fit within the trapezoid
                let textWidth;
                do {
                    context.font = `${fontSize}px ${selectedFontFamily}`;
                    textWidth = Math.max(...textLines.map(line => context.measureText(line).width));
                    if (textWidth > width / 2 - 10 && fontSize > 5) {
                        fontSize -= 1;
                    } else {
                        break;
                    }
                } while (textWidth > width / 2 - 10);
            }
        }

        // Draw image if uploaded
        const logoAdjust = document.getElementById("logoPosition").value;
        if (imageUploaded ) {
            if (currentset === "non") {
                const logoX = textX + (backgroundWidth - logoWidth) / 2 - 10;
                const logoY = textY - logoHeight / 2;
                context.drawImage(logoImage, logoX, logoY, logoWidth, logoHeight);
            } else {
                const logoX = textX + (backgroundWidth - 150) / 2 - 10;
                const logoY = textY - logoHeight / 2;
                if (logoAdjust === "Top") {
                    context.drawImage(logoImage, logoX, 0, 150, 50);
                } else if (logoAdjust === "Bottom") {
                    context.drawImage(logoImage, logoX, canvas.height - 50, 150, 50);
                }else if (logoAdjust === "Topleft") {
                    context.drawImage(logoImage, 0, 0, 150, 50);
                }else if (logoAdjust === "Topright") {
                    context.drawImage(logoImage, canvas.width - 150, 0, 150, 50);
                }else if (logoAdjust === "Bottomleft") {
                    context.drawImage(logoImage, 0,  canvas.height - 50, 150, 50);
                }else if (logoAdjust === "Bottomright") {
                    context.drawImage(logoImage, canvas.width - 150, canvas.height - 50, 150, 50);
                } else {
                    context.drawImage(logoImage, logoX, 0, 150, 50);
                    context.drawImage(logoImage, logoX, canvas.height - 50, 150, 50);
                }
            }
        } 

        // Draw text
        context.fillStyle = textColor;
        context.textAlign = "center";
        if(currentset === "non"){
            textLines.forEach((line, index) => {
                context.fillText(line, textX, textY + index * fontSize);
            });
        }
    }
    
    jQuery(document).ready(function ($) {

        $('#pageSelection').change((e) => {
            if (e.target.value === 'non') {
                $('#personaliseCover').css('display', "block"); // Enable and remove the click event
                $('#pagesCustom').css('display', "none"); // Enable and remove the click event
            } else {
                $('#personaliseCover').css('display', "none"); // Enable and remove the click event
                $('#pagesCustom').css('display', "block"); // Enable and remove the click event
            }
            $('#insideWrite').val('')
            clearCanvas();
            drawCanvas();
            drawTextAndLogo();
        });

        $("#selectionText").change((e) => {
            if (e.target.value === "uploadlogo") {
                imageUploaded = true;
            } else {
                imageUploaded = false;
            }
            clearCanvas();
            drawCanvas();
            drawTextAndLogo();
        })
        
        $("#textPosition").change(() => {
            clearCanvas();
            drawCanvas();
            drawTextAndLogo()})
        
        $("#textColor").change(() => {
            clearCanvas();
            drawCanvas();
            drawTextAndLogo()})

        $("#insideWrite").on('input', (e) => {
            clearCanvas();
            drawCanvas();
            drawTextAndLogo();
        });

        $("#logoPosition").change(() => {
            clearCanvas();
            drawCanvas();
            drawTextAndLogo()})

    $("#logoUploadIn").change(function (event) {
        const selectedValue = $(this).val();

    // Clear canvas and reset text and logo state
        clearCanvas();

        if (selectedValue === "Upload a logo") {
            imageUploaded = true;
            drawCanvas();
        } else {
            imageUploaded = false;
            initializeTextPosition();
            drawCanvas();
        }
    });


    $("#pageSelection").change((e) => {
        if (e.target.value === "Lined") {
            image.src = img2;
        } else if (e.target.value === "Non-Lined"){
            image.src = img3;
        } else {
            image.src = img;
        }
        changeImageHandler();
    })

    // Event listener for font style selection
    $("input[name='fontStyle']").on("change", function() {
        selectedFont = $(this).val(); // Update selected font
    drawCanvas(); // Redraw canvas with new font style
    });

    document.getElementById("personaliseProd").addEventListener("change", function() {
        const selectedOption = this.value;
    const textInputs = document.querySelectorAll("#textInput, #textInput2, #textInput3");
    const textarea = document.getElementById("writingArea");
    const fileUploadDiv = document.getElementById("uploadImage");

        // Hide all input elements initially
        textInputs.forEach(input => input.style.display = 'none');
    textarea.style.display = 'none';
    fileUploadDiv.style.display = 'none';

    // Clear canvas and hide logo if needed
    clearCanvas();

    // Show elements based on the selected option
    if (selectedOption === "Phrase") {
        textInputs.forEach(input => input.style.display = 'block');
    // Draw text and shapes
    drawCanvas(); // Call your drawing function here
        } else if (selectedOption === "Name or initial") {
        textarea.style.display = 'block';
    // Draw text and shapes
    drawCanvas(); // Call your drawing function here
        } else if (selectedOption === "Upload a logo") {
        fileUploadDiv.style.display = 'block';
    // Redraw canvas with logo if uploaded
    drawCanvas(); // Ensure the logo is redrawn on the canvas
        }
    });

    image.src = img; // Change the path to your image here

    const changeImageHandler = () => {
        image.onload = function () {
            const fixedWidth = 900;
            const fixedHeight = 600;
    
            canvas.width = fixedWidth;
            canvas.height = fixedHeight;
    
            // Scale image to fit within the canvas
            const imageAspectRatio = image.width / image.height;
            const canvasAspectRatio = fixedWidth / fixedHeight;
    
            let drawWidth, drawHeight;
            if (imageAspectRatio > canvasAspectRatio) {
                drawWidth = fixedWidth;
                drawHeight = fixedWidth / imageAspectRatio;
            } else {
                drawHeight = fixedHeight;
                drawWidth = fixedHeight * imageAspectRatio;
            }
    
            const xOffset = (fixedWidth - drawWidth) / 2;
            const yOffset = (fixedHeight - drawHeight) / 2;
    
            context.drawImage(image, xOffset, yOffset, drawWidth, drawHeight);
    
            initializeTextPosition();
            drawCanvas();
        };
    }

    changeImageHandler();


    // Event listeners for shape selection, text input, and other controls
    $("input[name='shapeSelect']").on("change", function () {
        drawCanvas();
    });

    document.getElementById("textInput").addEventListener("input", drawCanvas);
    document.getElementById("writingArea").addEventListener("input", drawCanvas);
    document.getElementById("fontSelect").addEventListener("change", drawCanvas); // Font selector


    $("#personaliseProd").change(function (event) {
        const selectedValue = $(this).val();

    // Clear canvas and reset text and logo state
    clearCanvas();

    if (selectedValue === "Upload a logo") {
        imageUploaded = true;
    drawCanvas();
        } else {
        imageUploaded = false;
    initializeTextPosition();
    drawCanvas();
        }
    });

    canvas.addEventListener("mouseover", () => {
        canvas.style.transform = `scale(${scale})`;
    });

    canvas.addEventListener("mouseout", () => {
        canvas.style.transform = "scale(1)";
    });

    document.addEventListener("keydown", (e) => {
        if ($("#pageSelection").val() === "non") {
            const moveAmount = 5;
            switch (e.key) {
                case "ArrowUp":
                textY -= moveAmount;
                break;
                case "ArrowDown":
                textY += moveAmount;
                break;
                case "ArrowLeft":
                textX -= moveAmount;
                break;
                case "ArrowRight":
                textX += moveAmount;
                break;
            }
            drawCanvas();
        }
    });

    document.getElementById("logoUpload").addEventListener("change", handleImageUpload);
    document.getElementById("logoUploadIn").addEventListener("change", handleImageUpload);
    document.getElementById("logoWidth").addEventListener("input", updateLogoSize);
    document.getElementById("logoHeight").addEventListener("input", updateLogoSize);

    function initializeTextPosition() {
        fontSize = 22; // Reset font size to default
    const textInput = document.getElementById("textInput").value;
    const writingAreaText = document.getElementById("writingArea").value;
    const text = textInput + (writingAreaText ? "\n" + writingAreaText : "");
    const textLines = text.split("\n");

    // Adjust font size to fit text within the background width
    let textWidth;
    do {
        context.font = `${fontSize}px ${selectedFont}`;
            textWidth = Math.max(...textLines.map(line => context.measureText(line).width));
            if (textWidth > maxBackgroundWidth && fontSize > 5) {
        fontSize -= 1; // Decrease font size incrementally
            } else {
                break;
            }
        } while (textWidth > maxBackgroundWidth);

    const textHeight = fontSize; // Updated text height with new font size
    const totalTextHeight = textHeight * textLines.length;

    const backgroundWidth = maxBackgroundWidth;
    textX = (canvas.width - backgroundWidth) / 2;
    textY = (canvas.height + shapeHeight) / 2 - 200;
    }

    function clearCanvas() {
        context.clearRect(0, 0, canvas.width, canvas.height);
    }

    function handleImageUpload(event) {
        const file = event.target.files[0];
    if (file) {
            const reader = new FileReader();
    reader.onload = function (e) {
        logoImage.src = e.target.result;
    logoImage.onload = function () {
        imageUploaded = true;
    drawCanvas();
                };
            };
    reader.readAsDataURL(file);
        }
    }

    function updateLogoSize() {
        logoWidth = parseInt(document.getElementById("logoWidth").value, 10);
    logoHeight = parseInt(document.getElementById("logoHeight").value, 10);
    drawCanvas();
    }

    context.roundRect = function (x, y, width, height, radius) {
        context.beginPath();
    context.moveTo(x + radius, y);
    context.lineTo(x + width - radius, y);
    context.arc(x + width - radius, y + radius, radius, 1.5 * Math.PI, 2 * Math.PI);
    context.lineTo(x + width, y + height - radius);
    context.arc(x + width - radius, y + height - radius, radius, 0, 0.5 * Math.PI);
    context.lineTo(x + radius, y + height);
    context.arc(x + radius, y + height - radius, radius, 0.5 * Math.PI, Math.PI);
    context.lineTo(x, y + radius);
    context.arc(x + radius, y + radius, radius, Math.PI, 1.5 * Math.PI);
    context.closePath();
    };

});

    function updateColor(color) {   
        document.getElementById('backColor').value = color;
        drawCanvas();
    }

    function updateTextColor(color) {
        document.getElementById('textColor').value = color;
        drawCanvas();
    }
</script>




 </div>
