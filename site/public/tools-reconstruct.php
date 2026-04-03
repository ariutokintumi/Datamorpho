<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Datamorpho Reconstructor</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        :root {
            --font-body: "Unifont", "Courier New", monospace;
            --bg: #ffffff;
            --text: #111111;
            --muted: #666666;
            --border: #dddddd;
        }

        body {
            margin: 0;
            font-family: var(--font-body);
            background: var(--bg);
            color: var(--text);
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        h1 {
            font-size: 28px;
            margin-bottom: 20px;
        }

        h2 {
            font-size: 20px;
            margin-top: 40px;
        }

        p {
            line-height: 1.6;
            margin-bottom: 16px;
        }

        .placeholder {
            margin-top: 40px;
            padding: 30px;
            border: 1px dashed var(--border);
            text-align: center;
            color: var(--muted);
        }

        .back {
            margin-bottom: 20px;
            display: inline-block;
            font-size: 14px;
        }
    </style>
</head>

<body>
<div class="container">

    <a class="back" href="/">← Back to Home</a>

    <h1>Datamorpho Reconstructor</h1>

    <p>
        The Datamorpho Reconstructor will allow users to reconstruct a hidden state from a Datamorphed file using a valid reconstruction object.
    </p>

    <p>
        Reconstruction is state-specific. Each reconstruction object targets exactly one hidden state and provides the information required to retrieve, reassemble, and decode that state from the carrier file.
    </p>

    <h2>What this tool will do</h2>

    <p>
        • Accept a Datamorphed carrier file<br>
        • Accept a reconstruction object (JSON or equivalent)<br>
        • Locate relevant payload fragments using offsets<br>
        • Apply fragment-level cryptographic operations<br>
        • Reassemble the target hidden state<br>
        • Output the reconstructed file
    </p>

    <h2>Important note</h2>

    <p>
        Without a valid reconstruction object, hidden states cannot be reconstructed. 
        The carrier file alone is insufficient to recover concealed data.
    </p>

    <div class="placeholder">
        Reconstructor interface coming soon.<br><br>
        This section will provide a web interface connected to the Datamorpho Python tooling.
    </div>

</div>
</body>
</html>