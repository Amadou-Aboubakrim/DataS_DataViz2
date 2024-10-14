<!DOCTYPE html>
<html>
<head>
    <title>Scraping Results</title>
</head>
<body>
    <h1>Scraping Results</h1>
    <ul>
        @foreach($titles as $title)
            <li>{{ $title }}</li>
        @endforeach
    </ul>
</body>
</html>
