<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class ImageClassificationService
{
    public function classify($fileName)
    {
        // @TODO: shell wrapper https://github.com/adambrett/php-shell-wrapper

        $storage = Storage::disk('bucket')->path(null);
        $location = config('7up.nsfw.location');

        $cmd = "docker run --name nsfw --rm -u $(id -u):$(id -g) \
            --mount type=bind,source={$storage},target=/storage \
            --mount type=bind,source={$location},target=/nsfw \
            bvlc/caffe:cpu \
            python /nsfw/classify_nsfw.py \
            --model_def /nsfw/nsfw_model/deploy.prototxt \
            --pretrained_model /nsfw/nsfw_model/resnet_50_1by2_nsfw.caffemodel \
            /storage/{$fileName} 2>/dev/null";

        if (is_array($score = explode('NSFW score:', shell_exec($cmd))) && count($score) > 1) {
            return (float) $score[1];
        }

        return 0;
    }
}
