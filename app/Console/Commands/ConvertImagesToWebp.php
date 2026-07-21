<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ConvertImagesToWebp extends Command
{
    protected $signature = 'images:webp 
                            {--path=public/uploads/products : Folder to scan}
                            {--width=800 : Max width in pixels}
                            {--quality=80 : WebP quality (1-100)}
                            {--delete-original : Delete original file after conversion}';

    protected $description = 'Resize and compress existing images into WebP format';

    public function handle()
    {
        $folder = base_path($this->option('path'));
        $maxWidth = (int) $this->option('width');
        $quality = (int) $this->option('quality');
        $deleteOriginal = $this->option('delete-original');

        if (!File::isDirectory($folder)) {
            $this->error("Folder not found: {$folder}");
            return 1;
        }

        $manager = new ImageManager(new Driver());

        $files = collect(File::allFiles($folder))
            ->filter(fn($file) => in_array(strtolower($file->getExtension()), ['jpg', 'jpeg', 'png']));

        if ($files->isEmpty()) {
            $this->info('Koi convert karne layak image nahi mili.');
            return 0;
        }

        $bar = $this->output->createProgressBar($files->count());
        $bar->start();

        $converted = 0;

        foreach ($files as $file) {
            $webpPath = $file->getPath() . '/' . $file->getFilenameWithoutExtension() . '.webp';

            if (File::exists($webpPath)) {
                $bar->advance();
                continue;
            }

            try {
                $image = $manager->read($file->getPathname());

                if ($image->width() > $maxWidth) {
                    $image->scale(width: $maxWidth);
                }

                $image->toWebp($quality)->save($webpPath);
                $converted++;

                if ($deleteOriginal) {
                    File::delete($file->getPathname());
                }
            } catch (\Exception $e) {
                $this->newLine();
                $this->warn("Fail: {$file->getFilename()} - {$e->getMessage()}");
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("Done! {$converted} images convert hui WebP mein.");

        return 0;
    }
}