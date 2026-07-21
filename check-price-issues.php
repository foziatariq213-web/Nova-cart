<?php
/**
 * check-price-issues.php
 *
 * Usage: php check-price-issues.php
 * Run this from your Laravel project root (C:\xampp\htdocs\ecommerce_system).
 *
 * Scans app/ and resources/views/ for two risky patterns:
 *
 *  1) "->price"      -> Wrong on Product model objects. Product only has
 *                       'new_price' and 'old_price'. Anything using
 *                       $product->price will silently return null.
 *
 *  2) "['new_price']" or ["new_price"] -> Wrong on cart/wishlist SESSION
 *                       arrays. Those arrays always store the key as
 *                       'price' (see cart.add / wishlist.add routes),
 *                       even though it was read from $product->new_price.
 *
 * This won't catch 100% of cases (it can't know if a variable is a
 * Product model or a session array), so review each match, but it will
 * flag every spot worth double-checking.
 */

$basePaths = [
    __DIR__ . '/app',
    __DIR__ . '/resources/views',
];

$issuesFound = 0;
$filesScanned = 0;

foreach ($basePaths as $basePath) {
    if (!is_dir($basePath)) {
        continue;
    }

    $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($basePath, FilesystemIterator::SKIP_DOTS)
    );

    foreach ($files as $file) {
        $filename = $file->getFilename();
        $isPhp = str_ends_with($filename, '.php');
        if (!$isPhp) {
            continue;
        }

        $filesScanned++;
        $lines = file($file->getPathname());
        $relativePath = str_replace(__DIR__ . DIRECTORY_SEPARATOR, '', $file->getPathname());

        foreach ($lines as $lineNumber => $line) {
            // Pattern 1: ->price (but not ->new_price or ->old_price)
            if (preg_match('/->price\b/', $line) && !preg_match('/->(new_price|old_price)\b/', $line)) {
                $issuesFound++;
                $trimmed = trim($line);
                echo "⚠️  [Product Model] {$relativePath}:" . ($lineNumber + 1) . "\n";
                echo "     {$trimmed}\n";
                echo "     -> Likely should be ->new_price (Product has no 'price' column)\n\n";
            }

            // Pattern 2: ['new_price'] or ["new_price"] array access
            if (preg_match('/\[\s*[\'"]new_price[\'"]\s*\]/', $line)) {
                $issuesFound++;
                $trimmed = trim($line);
                echo "⚠️  [Cart/Wishlist Array] {$relativePath}:" . ($lineNumber + 1) . "\n";
                echo "     {$trimmed}\n";
                echo "     -> If this reads from a cart/wishlist session array, it should be ['price'] instead\n\n";
            }
        }
    }
}

echo "----------------------------------------\n";
echo "Files scanned : {$filesScanned}\n";
echo "Potential issues : {$issuesFound}\n";

if ($issuesFound === 0) {
    echo "✅ No risky 'price' patterns found. You're good!\n";
} else {
    echo "❌ Review each line above. Not all matches are bugs -- check the context\n";
    echo "   (is it a \$product object, or a cart/wishlist session array?) before fixing.\n";
}
