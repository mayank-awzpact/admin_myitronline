<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error Report</title>
</head>

<body>
    <h1>An error occurred in your application</h1>
    <p><strong>Message:</strong> {{ $exception->getMessage() }}</p>
    <p><strong>File:</strong> {{ $exception->getFile() }}</p>
    <p><strong>Line:</strong> {{ $exception->getLine() }}</p>
    <p><strong>Trace:</ <pre>{{ $exception->getTraceAsString() }}</pre>
</body>

</html>
