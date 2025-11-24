<?php
$scriptName = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
$base_url = ($scriptName === '/') ? '' : $scriptName;
$featured = (!empty($news)) ? $news[0] : null;
$others = (!empty($news)) ? array_slice($news, 1) : [];
?>
<!DOCTYPE html>
<html lang="hy">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Նորություններ | StudentBiz</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Armenian:wght@300;400;600;700&family=Playfair+Display:wght@700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script>tailwind.config = { theme: { extend: { colors: { brand: { blue: '#253894', green: '#63A900' } }, fontFamily: { sans: ['Inter', 'Noto Sans Armenian'], serif: ['Playfair Display', 'serif'] } } } }</script>
    <style>
        body { background-color: #ffffff; color: #1e293b; }
        .separator { height: 4px; background: linear-gradient(90deg, #253894 0%, #63A900 100%); width: 60px; }
        .img-zoom { transition: transform 0.7s; } .group:hover .img-zoom { transform: scale(1.05); }
    </style>
</head>
<body class="flex flex-col min-h-screen">
    <?php include __DIR__ . '/partials/navbar.php'; ?>
    <header class="pt-32 pb-12 bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4">
            <p class="text-brand-green font-bold text-xs uppercase mb-2">Student Business Incubator</p>
            <h1 class="text-5xl font-serif font-bold text-brand-blue">Newsroom</h1>
            <div class="separator mt-6"></div>
        </div>
    </header>
    <main class="flex-1 max-w-7xl mx-auto px-4 py-16 w-full">
        <?php if (empty($news)): ?><div class="text-center py-32 text-gray-400"><i class="far fa-newspaper text-3xl mb-4"></i><p>Նորություններ դեռ չկան</p></div><?php else: ?>
            
            <?php if ($featured): 
                // Image Parser
                $fRaw = $featured['image_url'];
                $fImgs = (strpos($fRaw, '[') === 0) ? (json_decode($fRaw, true)?:[]) : [$fRaw];
                $fThumb = $fImgs[0] ?? '';
                $fFinal = (strpos($fThumb, 'http')===0) ? $fThumb : $base_url . '/' . ltrim($fThumb, '/');
            ?>
            <a href="<?= $base_url ?>/news/<?= $featured['id'] ?>" class="group grid grid-cols-1 lg:grid-cols-12 gap-10 items-center mb-20 cursor-pointer">
                <div class="lg:col-span-7 h-[400px] rounded-xl overflow-hidden relative"><img src="<?= htmlspecialchars($fFinal) ?>" class="w-full h-full object-cover img-zoom"><div class="absolute top-6 left-6 bg-brand-green text-white text-xs font-bold px-3 py-1.5 rounded uppercase">Featured</div></div>
                <div class="lg:col-span-5 pr-4">
                    <div class="text-sm text-gray-400 mb-4 font-bold"><?= date('d M, Y', strtotime($featured['publish_date'])) ?></div>
                    <h2 class="text-3xl font-bold text-brand-blue mb-4 group-hover:text-brand-green transition"><?= htmlspecialchars($featured['title']) ?></h2>
                    <p class="text-gray-600 text-lg line-clamp-3 mb-8"><?= htmlspecialchars($featured['content']) ?></p>
                    <span class="text-brand-blue font-bold border-b-2 border-brand-blue pb-1 group-hover:border-brand-green group-hover:text-brand-green transition">Կարդալ Ավելին</span>
                </div>
            </a>
            <?php endif; ?>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-12">
                <?php foreach ($others as $item): 
                    $iRaw = $item['image_url'];
                    $iImgs = (strpos($iRaw, '[') === 0) ? (json_decode($iRaw, true)?:[]) : [$iRaw];
                    $iThumb = $iImgs[0] ?? '';
                    $iFinal = (strpos($iThumb, 'http')===0) ? $iThumb : $base_url . '/' . ltrim($iThumb, '/');
                ?>
                <a href="<?= $base_url ?>/news/<?= $item['id'] ?>" class="group flex flex-col h-full">
                    <div class="h-56 rounded-lg overflow-hidden mb-6 relative"><img src="<?= htmlspecialchars($iFinal) ?>" class="w-full h-full object-cover img-zoom"></div>
                    <h3 class="text-xl font-bold text-brand-blue mb-3 group-hover:text-brand-green transition line-clamp-2"><?= htmlspecialchars($item['title']) ?></h3>
                    <p class="text-gray-500 text-sm line-clamp-3 flex-1"><?= htmlspecialchars($item['content']) ?></p>
                    <div class="pt-4 mt-4 border-t border-gray-100 flex justify-between items-center"><span class="text-xs font-bold text-gray-400">NEWS</span><span class="text-brand-green text-sm font-bold group-hover:translate-x-1 transition">Կարդալ &rarr;</span></div>
                </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>
    <footer class="bg-white border-t border-gray-200 py-8 text-center text-xs text-gray-400">&copy; 2025 StudentBiz Newsroom.</footer>
</body>
</html>