<?php
$scriptName = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
$base_url = ($scriptName === '/') ? '' : $scriptName;

// Image Parsing Logic
$rawImage = $item['image_url'];
$images = [];
if (strpos($rawImage, '[') === 0) {
    $decoded = json_decode($rawImage, true);
    $images = (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) ? $decoded : explode(',', str_replace(['[', ']', '"', '\\'], '', $rawImage));
} else {
    $images = [$rawImage];
}
$processedImages = array_map(function($img) use ($base_url) {
    $img = trim($img);
    if (empty($img)) return 'https://via.placeholder.com/800x600?text=No+Image';
    return (strpos($img, 'http') === 0) ? $img : $base_url . '/' . ltrim($img, '/');
}, $images);
?>
<!DOCTYPE html>
<html lang="hy">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($item['title']) ?> | StudentBiz</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Armenian:wght@300;400;600;700&family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>tailwind.config = { theme: { extend: { colors: { brand: { blue: '#253894', green: '#63A900' } }, fontFamily: { sans: ['Noto Sans Armenian', 'Inter'] } } } }</script>
    <style>.scrollbar-hide::-webkit-scrollbar { display: none; } .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }</style>
</head>
<body class="bg-white text-gray-800">
    <?php include __DIR__ . '/partials/navbar.php'; ?>
    <main class="max-w-4xl mx-auto px-4 pt-32 pb-20">
        <a href="<?= $base_url ?>/news" class="inline-flex items-center text-gray-500 hover:text-brand-blue mb-6 transition"><i class="fas fa-arrow-left mr-2"></i> Վերադառնալ լրահոսին</a>
        <h1 class="text-3xl md:text-5xl font-bold text-brand-blue mb-4 leading-tight"><?= htmlspecialchars($item['title']) ?></h1>
        <div class="flex items-center gap-4 text-sm text-gray-500 mb-8 border-b border-gray-100 pb-6"><span class="flex items-center gap-2"><i class="far fa-calendar-alt"></i> <?= date('d M, Y', strtotime($item['publish_date'])) ?></span><span class="text-brand-green font-bold uppercase">News</span></div>
        
        <div class="relative w-full rounded-2xl overflow-hidden mb-10 bg-gray-100 shadow-lg group">
            <?php if (count($processedImages) > 1): ?>
                <div class="flex overflow-x-auto snap-x snap-mandatory scrollbar-hide" id="main-slider">
                    <?php foreach ($processedImages as $img): ?><img src="<?= htmlspecialchars($img) ?>" class="w-full max-h-[600px] object-cover flex-shrink-0 snap-center"><?php endforeach; ?>
                </div>
                <button onclick="document.getElementById('main-slider').scrollBy({left:-500,behavior:'smooth'})" class="absolute left-4 top-1/2 -translate-y-1/2 w-10 h-10 bg-white/80 hover:bg-white rounded-full flex items-center justify-center shadow-md transition"><i class="fas fa-chevron-left"></i></button>
                <button onclick="document.getElementById('main-slider').scrollBy({left:500,behavior:'smooth'})" class="absolute right-4 top-1/2 -translate-y-1/2 w-10 h-10 bg-white/80 hover:bg-white rounded-full flex items-center justify-center shadow-md transition"><i class="fas fa-chevron-right"></i></button>
                <div class="absolute bottom-4 right-4 bg-black/60 text-white text-xs px-3 py-1 rounded-full backdrop-blur"><i class="fas fa-camera mr-1"></i> <?= count($processedImages) ?> photos</div>
            <?php else: ?>
                <img src="<?= htmlspecialchars($processedImages[0]) ?>" class="w-full max-h-[600px] object-cover">
            <?php endif; ?>
        </div>

        <article class="prose prose-lg max-w-none text-gray-700 leading-loose"><?= nl2br(htmlspecialchars($item['content'])) ?></article>
    </main>
    <footer class="bg-brand-blue text-white py-8 text-center text-sm">&copy; 2025 StudentBiz.</footer>
</body>
</html>