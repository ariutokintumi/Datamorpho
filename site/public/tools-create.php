<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Datamorpho Creator</title>
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

    <h1>Datamorpho Creator</h1>

    <p>
        The Datamorpho Creator will allow users to generate Datamorphed files from supported carrier formats.
    </p>

    <p>
        A valid base file (JPEG, TXT, or PDF) will be transformed into a Datamorphed carrier by embedding concealed payload data and attaching a public manifest that declares future hidden states.
    </p>

    <h2>What this tool will do</h2>

    <p>
        • Accept a base carrier file<br>
        • Accept one or more hidden state files<br>
        • Apply fragmentation and layout strategy<br>
        • Apply cryptographic transformations per fragment<br>
        • Embed payload into the carrier file<br>
        • Generate the corresponding reconstruction objects
    </p>

    <h2>Important note</h2>

    <p>
        The creation process defines the security properties of the Datamorphed file. 
        Choices such as fragmentation strategy, cryptographic suites, and reconstruction object handling directly affect resistance and behavior.
    </p>

    <div class="placeholder">
        Creator interface coming soon.<br><br>
        This section will provide a web interface connected to the Datamorpho Python tooling.
    </div>

</div>
</body>
</html>