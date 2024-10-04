const currentPageUrl = window.location.href;

        // Function to generate the QR code in the popup window
        function openQRPopup(url) {
            // Open a new window
            const popup = window.open('', 'QR Code', 'width=400,height=400');

            // Create the HTML structure in the popup
            popup.document.write(`
                <html>
                    <head>
                        <title>QR Code Share</title>
                        <style>
                            body {
                                font-family: Arial, sans-serif;
                                text-align: center;
                                padding: 20px;
                            }
                            #qr-code {
                                margin: 20px auto;
                            }
                            .close-btn {
                                background-color: red;
                                color: white;
                                padding: 10px 20px;
                                border: none;
                                cursor: pointer;
                            }
                            .close-btn:hover {
                                background-color: darkred;
                            }
                        </style>
                    </head>
                    <body>
                        <h2>Scan this QR Code to share:</h2>
                        <div id="qr-code"></div>
                        <p><a id="share-link" href="${url}" target="_blank">${url}</a></p>
                        <button class="close-btn" onclick="window.close()">Close</button>
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
                        <script>
                            // Generate the QR code inside the popup
                            new QRCode(document.getElementById('qr-code'), {
                                text: "${url}",
                                width: 128,
                                height: 128
                            });
                        </script>
                    </body>
                </html>
            `);

            // Make sure the popup window gets focused
            popup.focus();
        }

        // Add event listener to the share button
        document.getElementById('share-button').addEventListener('click', function() {
            // Open the popup with the QR code and the link
            openQRPopup(currentPageUrl);
        });

        