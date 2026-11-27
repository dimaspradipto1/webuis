<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileUploadService
{
    /**
     * Upload single file to specified disk and directory.
     */
    public function upload(UploadedFile $file, string $directory = 'uploads', string $disk = 'public'): string
    {
        return $file->store($directory, $disk);
    }

    /**
     * Upload and optimize thumbnail image (scale down to maxWidth and compress).
     */
    public function uploadThumbnail(
        UploadedFile $file,
        string $directory = 'news',
        int $maxWidth = 1200,
        int $quality = 82,
        string $disk = 'public'
    ): string {
        $filename = trim($directory, '/').'/'.Str::random(40).'.jpg';
        $fullTarget = storage_path('app/public/'.$filename);

        if (! is_dir(dirname($fullTarget))) {
            mkdir(dirname($fullTarget), 0755, true);
        }

        if (extension_loaded('gd')) {
            $srcPath = $file->getRealPath();
            $info = @getimagesize($srcPath);

            if ($info && in_array($info['mime'], ['image/jpeg', 'image/png', 'image/webp'])) {
                $origW = $info[0];
                $origH = $info[1];

                $srcImg = match ($info['mime']) {
                    'image/jpeg' => @imagecreatefromjpeg($srcPath),
                    'image/png' => @imagecreatefrompng($srcPath),
                    'image/webp' => @imagecreatefromwebp($srcPath),
                    default => null,
                };

                if ($srcImg) {
                    $targetW = min($maxWidth, $origW);
                    $targetH = (int) round(($origH / $origW) * $targetW);

                    $dstImg = imagecreatetruecolor($targetW, $targetH);
                    $white = imagecolorallocate($dstImg, 255, 255, 255);
                    imagefill($dstImg, 0, 0, $white);

                    imagecopyresampled($dstImg, $srcImg, 0, 0, 0, 0, $targetW, $targetH, $origW, $origH);
                    imagejpeg($dstImg, $fullTarget, $quality);

                    imagedestroy($srcImg);
                    imagedestroy($dstImg);

                    return $filename;
                }
            }
        }

        return $file->store($directory, $disk);
    }

    /**
     * Upload an array of files.
     *
     * @param  array<UploadedFile>  $files
     * @return array<string>
     */
    public function uploadMultiple(array $files, string $directory, string $disk = 'public'): array
    {
        $paths = [];
        foreach ($files as $file) {
            if ($file instanceof UploadedFile) {
                $paths[] = $file->store($directory, $disk);
            }
        }

        return $paths;
    }

    /**
     * Safely delete a file if it exists.
     */
    public function delete(?string $path, string $disk = 'public'): bool
    {
        if (! empty($path) && Storage::disk($disk)->exists($path)) {
            return Storage::disk($disk)->delete($path);
        }

        return false;
    }

    /**
     * Safely delete multiple files.
     *
     * @param  array<string>  $paths
     */
    public function deleteMultiple(array $paths, string $disk = 'public'): void
    {
        foreach ($paths as $path) {
            $this->delete($path, $disk);
        }
    }

    /**
     * Process embedded base64 images in HTML content, saving them as files
     * and replacing base64 data URIs with proper /storage/news/content/... URLs.
     */
    public function processBase64ContentImages(?string $content, string $directory = 'news/content', string $disk = 'public'): ?string
    {
        if (empty($content) || ! str_contains($content, 'data:image/')) {
            return $content;
        }

        return preg_replace_callback('/<img[^>]+src=["\'](data:image\/([a-zA-Z0-9\+\-\.]+);base64,([^"\']+))["\'][^>]*>/i', function ($matches) use ($directory, $disk) {
            $fullImgTag = $matches[0];
            $base64Data = $matches[1];
            $imageExtension = strtolower($matches[2]);
            $rawBinary = base64_decode($matches[3]);

            if (! $rawBinary) {
                return $fullImgTag;
            }

            if ($imageExtension === 'jpeg') {
                $imageExtension = 'jpg';
            } elseif (! in_array($imageExtension, ['jpg', 'png', 'webp', 'gif', 'svg'])) {
                $imageExtension = 'jpg';
            }

            $filename = trim($directory, '/') . '/' . Str::random(40) . '.' . $imageExtension;
            Storage::disk($disk)->put($filename, $rawBinary);

            $assetUrl = asset('storage/' . $filename);

            return str_replace($base64Data, $assetUrl, $fullImgTag);
        }, $content);
    }

    /**
     * Extract and delete images embedded inside HTML content (e.g. TinyMCE uploads).
     */
    public function deleteEmbeddedContentImages(?string $htmlContent, string $disk = 'public'): void
    {
        if (empty($htmlContent)) {
            return;
        }

        preg_match_all('/src="[^"]*\/storage\/([a-zA-Z0-9_\-\/]+\.[a-zA-Z0-9]+)"/i', $htmlContent, $matches);
        if (! empty($matches[1])) {
            foreach ($matches[1] as $imageRelativePath) {
                $this->delete($imageRelativePath, $disk);
            }
        }
    }
}
