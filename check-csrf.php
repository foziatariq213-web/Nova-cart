<?php
/**
 * check-csrf.php
 *
 * Usage: php check-csrf.php
 * Run this from your Laravel project root (C:\xampp\htdocs\ecommerce_system).
 *
 * Scans all .blade.php files under resources/views and reports any
 * <form> tag using POST/PUT/PATCH/DELETE method that does NOT have
 * a matching @csrf directive before its closing </form> tag.
 */

$viewsPath = __DIR__ . '/resources/views';

if (!is_dir($viewsPath)) {
    die("❌ Could not find resources/views folder. Run this script from your project root.\n");
}

$files = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($viewsPath, FilesystemIterator::SKIP_DOTS)
);

$issuesFound = 0;
$filesScanned = 0;

foreach ($files as $file) {
    if (!str_ends_with($file->getFilename(), '.blade.php')) {
        continue;
    }

    $filesScanned++;
    $content = file_get_contents($file->getPathname());
    $relativePath = str_replace(__DIR__ . DIRECTORY_SEPARATOR, '', $file->getPathname());

    // Find all <form ...> ... </form> blocks
    preg_match_all('/<form\b[^>]*>(.*?)<\/form>/is', $content, $matches, PREG_OFFSET_CAPTURE);

    foreach ($matches[0] as $index => $fullMatch) {
        $formTag = $fullMatch[0];
        $offset = $fullMatch[1];

        // Only care about forms that submit data (POST/PUT/PATCH/DELETE)
        // Forms with no explicit method default to GET, which doesn't need @csrf
        if (!preg_match('/method\s*=\s*["\']post["\']/i', $formTag)) {
            continue;
        }

        // Check if @csrf exists inside this form block
        if (!preg_match('/@csrf/i', $formTag)) {
            $issuesFound++;
            $lineNumber = substr_count(substr($content, 0, $offset), "\n") + 1;
            echo "⚠️  Missing @csrf -> {$relativePath} (around line {$lineNumber})\n";
        }
    }
}

echo "\n----------------------------------------\n";
echo "Files scanned : {$filesScanned}\n";
echo "Forms missing @csrf : {$issuesFound}\n";

if ($issuesFound === 0) {
    echo "✅ All POST forms have @csrf. You're good!\n";
} else {
    echo "❌ Fix the files listed above by adding @csrf right after the <form> tag.\n";
}
