<?php
/**
 * STUDENTBIZ HOMEPAGE - ENTERPRISE EDITION
 * Stack: PHP 8, TailwindCSS, Vanilla JS (ES6+)
 */

// 1. GLOBAL CONFIGURATION & HELPERS
// ------------------------------------------------------------------
$scriptName = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
$base_url = ($scriptName === '/') ? '' : $scriptName;

// Helper: Smart Image Parser (Handles JSON, Strings, and Broken paths)
function parseImages($raw, $base) {
    $images = [];
    if (strpos($raw, '[') === 0) {
        $decoded = json_decode($raw, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            $images = $decoded;
        } else {
            // Emergency cleanup for broken JSON
            $clean = str_replace(['[', ']', '"', '\\'], '', $raw);
            if (!empty($clean)) $images = explode(',', $clean);
        }
    } else {
        $images = [$raw];
    }
    
    return array_map(function($img) use ($base) {
        $img = trim($img);
        if (empty($img)) return 'https://via.placeholder.com/800x600?text=No+Image';
        return (strpos($img, 'http') === 0) ? $img : $base . '/' . ltrim($img, '/');
    }, $images);
}
?>
<!DOCTYPE html>
<html lang="hy">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Աշակերտական/Ուսանողական ընկերություններ</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Armenian:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            blue: '#253894',
                            green: '#63A900',
                            dark: '#0f172a',
                            light: '#f8fafc'
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'Noto Sans Armenian', 'sans-serif'],
                    },
                    boxShadow: {
                        'soft': '0 10px 40px -10px rgba(0,0,0,0.08)',
                        'glow': '0 0 20px rgba(99, 169, 0, 0.3)'
                    }
                }
            }
        }
    </script>

    <style>
        /* Base */
        body { background-color: #ffffff; color: #1e293b; scroll-behavior: smooth; }
        
        /* Utilities */
        .text-gradient { background: linear-gradient(135deg, #253894 0%, #63A900 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
        
        /* Animations */
        .fade-in-up { animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; transform: translateY(30px); }
        @keyframes fadeInUp { to { opacity: 1; transform: translateY(0); } }
        
        /* Slider Transitions */
        .hero-slide {
            opacity: 0;
            transition: opacity 1s ease-in-out, transform 8s ease-out;
            transform: scale(1.05);
            position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;
        }
        .hero-slide.active { opacity: 1; transform: scale(1); }
    </style>
</head>
<body class="antialiased selection:bg-brand-green selection:text-white flex flex-col min-h-screen">

    <?php include __DIR__ . '/partials/navbar.php'; ?>

    <section class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
        <div class="absolute top-0 right-0 w-1/2 h-full bg-gradient-to-l from-blue-50 via-transparent to-transparent -z-10"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                
                <div class="z-10 fade-in-up" style="animation-delay: 0.1s;">

                    
                    <h1 class="text-5xl lg:text-7xl font-bold leading-tight mb-6 text-brand-blue tracking-tight">
                        Ստեղծիր քո <br>
                        <span class="text-gradient">Ապագա Բիզնեսը</span>
                    </h1>
                    
                    <p class="text-lg text-gray-500 mb-10 leading-relaxed max-w-lg border-l-4 border-brand-green pl-6">
                        Միացեք Հայաստանի ամենամեծ ուսանողական բիզնես համայնքին: Ստացեք ֆինանսավորում, մենթորների աջակցություն և զարգացրեք ձեր ստարտափը:
                    </p>
                    
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="<?= $base_url ?>/apply" class="group px-8 py-4 bg-brand-blue text-white rounded-xl font-bold shadow-lg hover:shadow-soft hover:bg-brand-green transition-all duration-300 flex items-center justify-center gap-3">
                            <span>Ուղարկել Հայտ</span>
                            <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                        </a>
                        <a href="#news" class="px-8 py-4 bg-white text-gray-700 border border-gray-200 rounded-xl font-bold hover:bg-gray-50 transition-all duration-300 flex items-center justify-center">
                            Իմանալ ավելին
                        </a>
                    </div>
                </div>

                <div class="relative h-[600px] w-full rounded-[2rem] overflow-hidden shadow-2xl fade-in-up border-[6px] border-white" style="animation-delay: 0.3s;">
                    <div class="absolute inset-0 bg-gradient-to-t from-brand-blue/80 via-transparent to-transparent z-10"></div>
                    
                    <div class="absolute bottom-10 left-10 z-20 text-white">
                        <p class="text-sm font-bold uppercase tracking-widest mb-2 opacity-80">հաջողության պատմություններ</p>
                        <h3 class="text-3xl font-bold">մտահաղացումից դեպի իրականություն</h3>
                    </div>

                    <div id="hero-slider" class="w-full h-full relative bg-gray-200">
                        <img src="<?= $base_url ?>/uploads/1.jpg" class="hero-slide active">
                        <img src="<?= $base_url ?>/uploads/2.jpg" class="hero-slide">
                        <img src="<?= $base_url ?>/uploads/3.jpg" class="hero-slide">
                        <img src="<?= $base_url ?>/uploads/4.jpg" class="hero-slide">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="calendar" class="py-24 bg-white border-t border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-6">
                <div>
                    <span class="text-brand-green font-bold text-sm uppercase tracking-wider">ժամանակացույց</span>
                    <h2 class="text-4xl font-bold text-brand-blue mt-2">Օրացույց և Միջոցառումներ</h2>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-red-500"></span> <span class="text-xs text-gray-500 mr-3">վերջնաժամկետ</span>
                    <span class="w-3 h-3 rounded-full bg-blue-500"></span> <span class="text-xs text-gray-500 mr-3">հանդիպում</span>
                    <span class="w-3 h-3 rounded-full bg-brand-green"></span> <span class="text-xs text-gray-500">միջոցառում</span>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-3xl shadow-soft border border-gray-100 p-8 h-full relative overflow-hidden">
                        <div class="absolute top-0 left-0 w-full h-2 bg-brand-blue"></div>
                        
                        <div class="flex justify-between items-center mb-8">
                            <h3 class="text-2xl font-bold text-gray-800 font-sans"><?php echo date('F Y'); ?></h3>
                            <div class="bg-gray-100 px-3 py-1 rounded-lg text-xs font-bold text-gray-500">Today</div>
                        </div>
                        
                        <div class="grid grid-cols-7 gap-2 text-center text-xs font-bold text-gray-400 mb-6 uppercase tracking-wide">
                            <div>Mo</div><div>Tu</div><div>We</div><div>Th</div><div>Fr</div><div>Sa</div><div>Su</div>
                        </div>
                        
                        <div id="calendar-grid" class="grid grid-cols-7 gap-3 text-sm font-medium">
                            </div>
                    </div>
                </div>

                <div class="lg:col-span-2 space-y-6">
                    <?php if (empty($events)): ?>
                        <div class="flex flex-col items-center justify-center h-full p-10 bg-gray-50 rounded-3xl border-2 border-dashed border-gray-200 text-center">
                            <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mb-4 shadow-sm">
                                <i class="far fa-calendar-times text-2xl text-gray-400"></i>
                            </div>
                            <h4 class="text-lg font-bold text-gray-600">Միջոցառումներ չկան</h4>
                            <p class="text-gray-400 text-sm">Ստուգեք ավելի ուշ կամ կապվեք մեզ հետ:</p>
                        </div>
                    <?php else: ?>
                        <?php foreach ($events as $event): 
                            $style = match($event['type']) {
                                'deadline' => ['border' => 'border-red-500', 'text' => 'text-red-500', 'bg' => 'bg-red-50', 'icon' => 'fa-exclamation-circle'],
                                'meeting'  => ['border' => 'border-blue-500', 'text' => 'text-blue-500', 'bg' => 'bg-blue-50', 'icon' => 'fa-users'],
                                default    => ['border' => 'border-brand-green', 'text' => 'text-brand-green', 'bg' => 'bg-green-50', 'icon' => 'fa-calendar-check']
                            };
                        ?>
                        <div class="group flex flex-col md:flex-row bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-lg transition-all duration-300 cursor-pointer relative overflow-hidden">
                            <div class="absolute top-0 left-0 w-1.5 h-full <?= $style['border'] ?> bg-current"></div>
                            
                            <div class="flex-shrink-0 md:pr-8 mb-4 md:mb-0 flex flex-col items-center justify-center border-b md:border-b-0 md:border-r border-gray-100 min-w-[120px]">
                                <span class="text-4xl font-bold <?= $style['text'] ?>"><?= date('d', strtotime($event['event_date'])) ?></span>
                                <span class="text-gray-400 uppercase text-xs font-bold tracking-wider mt-1"><?= date('F', strtotime($event['event_date'])) ?></span>
                            </div>
                            
                            <div class="pl-0 md:pl-8 flex-1 flex flex-col justify-center">
                                <div class="flex items-center gap-3 mb-2">
                                    <span class="<?= $style['bg'] ?> <?= $style['text'] ?> text-[10px] font-bold px-2 py-1 rounded uppercase tracking-wide flex items-center gap-1">
                                        <i class="fas <?= $style['icon'] ?>"></i> <?= $event['type'] ?>
                                    </span>
                                    <span class="text-gray-300 text-xs">|</span>
                                    <span class="text-gray-400 text-xs font-medium"><?= date('l', strtotime($event['event_date'])) ?></span>
                                </div>
                                <h4 class="text-xl font-bold text-brand-blue group-hover:text-brand-green transition-colors">
                                    <?= htmlspecialchars($event['title']) ?>
                                </h4>
                            </div>
                            
                            <div class="hidden md:flex items-center px-4 text-gray-300 group-hover:text-brand-blue transition-transform group-hover:translate-x-2">
                                <i class="fas fa-chevron-right text-xl"></i>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <section id="news" class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-end mb-12">
                <div>
                    <span class="text-brand-green font-bold text-sm uppercase tracking-wider">Updates</span>
                    <h2 class="text-3xl font-bold text-brand-blue mt-2">Վերջին Նորություններ</h2>
                </div>
                <a href="<?= $base_url ?>/news" class="hidden md:flex items-center gap-2 text-brand-blue font-bold hover:text-brand-green transition">
                    <span>Տեսնել բոլորը</span> <i class="fas fa-long-arrow-alt-right"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <?php if (empty($news)): ?>
                    <div class="col-span-3 text-center py-12 text-gray-400 italic">Նորություններ դեռ չկան</div>
                <?php else: ?>
                    <?php foreach (array_slice($news, 0, 3) as $item): 
                        // Smart Image Parsing
                        $imgs = parseImages($item['image_url'], $base_url);
                        $uniqueID = 'news-' . $item['id'];
                    ?>
                    <article class="group bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-soft transition-all duration-500 flex flex-col h-full border border-gray-100">
                        
                        <div class="h-56 bg-gray-200 relative overflow-hidden">
                            <?php if (count($imgs) > 1): ?>
                                <div class="w-full h-full flex overflow-x-auto snap-x snap-mandatory scrollbar-hide" id="<?= $uniqueID ?>">
                                    <?php foreach ($imgs as $img): ?>
                                        <img src="<?= htmlspecialchars($img) ?>" class="w-full h-full object-cover flex-shrink-0 snap-center">
                                    <?php endforeach; ?>
                                </div>
                                <div class="absolute inset-0 flex items-center justify-between px-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
                                    <button onclick="document.getElementById('<?= $uniqueID ?>').scrollBy({left: -300, behavior: 'smooth'})" class="w-8 h-8 bg-white/90 rounded-full shadow-md text-brand-blue flex items-center justify-center pointer-events-auto hover:scale-110 transition"><i class="fas fa-chevron-left text-xs"></i></button>
                                    <button onclick="document.getElementById('<?= $uniqueID ?>').scrollBy({left: 300, behavior: 'smooth'})" class="w-8 h-8 bg-white/90 rounded-full shadow-md text-brand-blue flex items-center justify-center pointer-events-auto hover:scale-110 transition"><i class="fas fa-chevron-right text-xs"></i></button>
                                </div>
                                <div class="absolute bottom-3 right-3 bg-black/50 backdrop-blur text-white text-[10px] font-bold px-2 py-1 rounded-full">
                                    1 / <?= count($imgs) ?>
                                </div>
                            <?php else: ?>
                                <img src="<?= htmlspecialchars($imgs[0]) ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            <?php endif; ?>
                            
                            <div class="absolute top-4 left-4 bg-white text-brand-blue text-xs font-bold px-3 py-1.5 rounded-lg shadow-md uppercase tracking-wider">News</div>
                        </div>

                        <div class="p-8 flex-1 flex flex-col">
                            <div class="text-xs text-gray-400 mb-3 flex items-center gap-2 font-medium">
                                <i class="far fa-calendar"></i> <?= date('F d, Y', strtotime($item['publish_date'])) ?>
                            </div>
                            <h3 class="text-xl font-bold text-brand-blue mb-3 leading-snug group-hover:text-brand-green transition-colors">
                                <a href="<?= $base_url ?>/news/<?= $item['id'] ?>">
                                    <?= htmlspecialchars($item['title']) ?>
                                </a>
                            </h3>
                            <p class="text-gray-500 text-sm leading-relaxed line-clamp-3 mb-6 flex-1">
                                <?= htmlspecialchars($item['content']) ?>
                            </p>
                            
                            <a href="<?= $base_url ?>/news/<?= $item['id'] ?>" class="inline-flex items-center text-brand-blue font-bold text-sm hover:text-brand-green transition-colors">
                                Կարդալ ավելին <i class="fas fa-arrow-right ml-2 text-xs transition-transform group-hover:translate-x-1"></i>
                            </a>
                        </div>
                    </article>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            
            <div class="mt-12 text-center md:hidden">
                <a href="<?= $base_url ?>/news" class="btn-secondary px-6 py-3 rounded-xl border font-bold">Տեսնել բոլորը</a>
            </div>
        </div>
    </section>

    <section id="gallery" class="py-24 bg-white border-t border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <h2 class="text-4xl font-bold text-brand-blue mb-4">Մեր <span class="text-gradient">Տեսադարանը</span></h2>
                <p class="text-gray-500 text-lg">Լավագույն պահերը և ուսանողական ձեռքբերումները:</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                <?php foreach (array_slice($gallery, 0, 6) as $media): 
                    // Logic for JSON Media
                    $content = json_decode($media['media_url'], true);
                    if (!is_array($content)) {
                        $content = [['type' => $media['type'], 'url' => $media['media_url']]];
                    }
                    $uid = 'home-gal-' . $media['id'];
                    $count = count($content);
                ?>
                
                <div class="relative aspect-[4/3] rounded-2xl overflow-hidden group shadow-md hover:shadow-2xl transition-all duration-500 bg-gray-100 border border-gray-200">
                    
                    <?php if ($count > 1): ?>
                        <div class="w-full h-full flex overflow-x-auto snap-x snap-mandatory scrollbar-hide relative" id="<?= $uid ?>">
                            <?php foreach ($content as $item): 
                                $src = (strpos($item['url'], 'http') === 0) ? $item['url'] : $base_url . '/' . ltrim($item['url'], '/');
                            ?>
                                <div class="w-full h-full flex-shrink-0 snap-center relative bg-black">
                                    <?php if ($item['type'] === 'video'): ?>
                                        <video src="<?= htmlspecialchars($src) ?>" class="w-full h-full object-cover" muted loop onmouseover="this.play()" onmouseout="this.pause()"></video>
                                        <div class="absolute inset-0 flex items-center justify-center pointer-events-none"><i class="fas fa-play-circle text-white/50 text-5xl"></i></div>
                                    <?php else: ?>
                                        <img src="<?= htmlspecialchars($src) ?>" class="w-full h-full object-cover">
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <button onclick="document.getElementById('<?= $uid ?>').scrollBy({left: -400, behavior: 'smooth'})" class="absolute left-2 top-1/2 -translate-y-1/2 w-10 h-10 bg-white/90 rounded-full shadow flex items-center justify-center opacity-0 group-hover:opacity-100 transition hover:scale-110"><i class="fas fa-chevron-left"></i></button>
                        <button onclick="document.getElementById('<?= $uid ?>').scrollBy({left: 400, behavior: 'smooth'})" class="absolute right-2 top-1/2 -translate-y-1/2 w-10 h-10 bg-white/90 rounded-full shadow flex items-center justify-center opacity-0 group-hover:opacity-100 transition hover:scale-110"><i class="fas fa-chevron-right"></i></button>
                        
                        <div class="absolute top-3 right-3 bg-black/60 backdrop-blur text-white text-xs font-bold px-3 py-1.5 rounded-lg"><i class="fas fa-clone mr-1"></i> <?= $count ?></div>

                    <?php else: ?>
                        <?php 
                            $first = $content[0]; 
                            $src = (strpos($first['url'], 'http') === 0) ? $first['url'] : $base_url . '/' . ltrim($first['url'], '/');
                        ?>
                        <div class="w-full h-full cursor-pointer" onclick="openLightbox('<?= $first['type'] ?>', '<?= htmlspecialchars($src) ?>')">
                            <?php if ($first['type'] === 'video'): ?>
                                <video src="<?= htmlspecialchars($src) ?>" class="w-full h-full object-cover" muted loop onmouseover="this.play()" onmouseout="this.pause()"></video>
                                <div class="absolute top-3 left-3 bg-white/90 text-brand-blue text-xs font-bold px-2 py-1 rounded shadow">VIDEO</div>
                            <?php else: ?>
                                <img src="<?= htmlspecialchars($src) ?>" class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <div class="absolute bottom-0 left-0 w-full p-4 bg-gradient-to-t from-black/80 via-black/40 to-transparent opacity-0 group-hover:opacity-100 transition duration-300 pointer-events-none">
                        <p class="text-white text-sm font-bold truncate"><?= htmlspecialchars($media['caption']) ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <div class="text-center">
                <a href="<?= $base_url ?>/gallery" class="inline-block px-10 py-4 rounded-full border-2 border-brand-blue text-brand-blue font-bold hover:bg-brand-blue hover:text-white transition-all duration-300 shadow-lg transform hover:-translate-y-1">
                    Տեսնել Ամբողջը
                </a>
            </div>
        </div>
    </section>

<footer class="relative bg-[#1a237e] text-white pt-20 pb-10 overflow-hidden font-sans">
    
    <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-brand-blue via-brand-green to-brand-blue"></div>

    <div class="absolute inset-0 opacity-5 pointer-events-none" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 40px 40px;"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">
            
            <div class="space-y-6">
                <div class="bg-white p-3 rounded-xl inline-block shadow-lg">
                    <img src="<?= $base_url ?>/uploads/logo.webp" alt="StudentBiz" class="h-10 w-auto object-contain">
                </div>
                <p class="text-blue-100 text-sm leading-relaxed opacity-80 max-w-xs">
                  Մենք կառուցում ենք կայուն կամուրջ բիզնեսի և կրթության միջև՝ զարգացնելով մարդկային կապիտալը և ստեղծելով արժեքավոր ապագա:
                </p>
                <div class="flex gap-4">
                    <a href="#" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-brand-green hover:text-white transition-all duration-300">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-brand-green hover:text-white transition-all duration-300">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-brand-green hover:text-white transition-all duration-300">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                </div>
            </div>

            <div>
                <h4 class="text-lg font-bold mb-6 text-white border-l-4 border-brand-green pl-3">Մենյու</h4>
                <ul class="space-y-3">
                    <li><a href="#news" class="text-blue-200 hover:text-white hover:translate-x-1 transition-all duration-300 inline-block">Նորություններ</a></li>
                    <li><a href="#calendar" class="text-blue-200 hover:text-white hover:translate-x-1 transition-all duration-300 inline-block">Միջոցառումներ</a></li>
                    <li><a href="#gallery" class="text-blue-200 hover:text-white hover:translate-x-1 transition-all duration-300 inline-block">Տեսադարան</a></li>
                    <li><a href="<?= $base_url ?>/apply" class="text-brand-green font-bold hover:text-white hover:translate-x-1 transition-all duration-300 inline-block">Դիմել &rarr;</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-lg font-bold mb-6 text-white border-l-4 border-brand-green pl-3">Կապ Մեզ Հետ</h4>
                <ul class="space-y-4 text-blue-100">
                    <li class="flex items-start gap-3">
                        <i class="fas fa-map-marker-alt mt-1 text-brand-green"></i>
                        <span class="text-sm">Armenia , Yerevan
Abovyan str 34, 0009<br></span>
                    </li>
                    <li class="flex items-center gap-3">
                        <i class="fas fa-phone-alt text-brand-green"></i>
                        <span class="text-sm">+374 (11) 52 81 12</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <i class="fas fa-envelope text-brand-green"></i>
                        <span class="text-sm">info@bea.am</span>
                    </li>
                </ul>
            </div>

            <div class="bg-white/5 p-6 rounded-2xl border border-white/10">
                <h5 class="font-bold text-white mb-2">Ունե՞ք հարցեր</h5>
                <p class="text-xs text-blue-200 mb-4">Գրեք մեզ և մենք սիրով կպատասխանենք ձեր բոլոր հարցերին:</p>
                <a href="mailto:info@bea.am" class="block w-full text-center py-2 rounded-lg bg-white text-brand-blue font-bold text-sm hover:bg-brand-green hover:text-white transition-all shadow-md">
                    Գրել Նամակ
                </a>
            </div>
        </div>

        <div class="border-t border-white/10 pt-8 flex flex-col md:flex-row justify-between items-center gap-4 text-xs text-blue-300/60">
            <p>&copy; 2025 Pupil Student Companies. All rights reserved.</p>
            <div class="flex gap-6">
                <a href="#" class="hover:text-white transition">Privacy Policy</a>
                <a href="#" class="hover:text-white transition">Terms of Service</a>
            </div>
        </div>
    </div>
</footer>

    <div id="lightbox" class="hidden fixed inset-0 z-[100] bg-[#0f172a]/95 backdrop-blur-xl flex items-center justify-center opacity-0 transition-opacity duration-300" onclick="closeLightbox()">
        <button class="absolute top-6 right-6 text-white/60 hover:text-white text-4xl transition z-50 rotate-0 hover:rotate-90 duration-300"><i class="fas fa-times"></i></button>
        <div class="relative w-full max-w-6xl p-4 md:p-10 flex flex-col items-center justify-center h-full" onclick="event.stopPropagation()">
             <div id="lightbox-content" class="w-full h-auto max-h-full flex items-center justify-center rounded-lg overflow-hidden shadow-2xl"></div>
        </div>
    </div>

    <script>
        // --- HERO SLIDER ---
        class HeroSlider {
            constructor() {
                this.slides = document.querySelectorAll('.hero-slide');
                this.current = 0;
                if(this.slides.length) this.init();
            }
            init() {
                setInterval(() => {
                    this.slides[this.current].classList.remove('active');
                    this.current = (this.current + 1) % this.slides.length;
                    this.slides[this.current].classList.add('active');
                }, 5000); // Slower, smoother 5s
            }
        }

        // --- CALENDAR LOGIC (Synced with PHP) ---
        class EventCalendar {
            constructor() {
                this.grid = document.getElementById('calendar-grid');
                if(this.grid) this.render();
            }
            render() {
                const dbEvents = <?php echo isset($eventsJson) ? $eventsJson : '[]'; ?>;
                const today = new Date();
                const daysInMonth = new Date(today.getFullYear(), today.getMonth() + 1, 0).getDate();
                const firstDayIndex = new Date(today.getFullYear(), today.getMonth(), 1).getDay(); 
                const startPadding = (firstDayIndex === 0 ? 6 : firstDayIndex - 1);

                this.grid.innerHTML = '';
                
                // Empty slots
                for(let i=0; i<startPadding; i++) this.grid.appendChild(document.createElement('div'));

                // Days
                for(let day=1; day<=daysInMonth; day++) {
                    const el = document.createElement('div');
                    el.className = 'w-10 h-10 flex items-center justify-center rounded-full text-gray-500 font-medium cursor-default mx-auto transition-all duration-300';
                    el.textContent = day;

                    // Check events
                    const hasEvent = dbEvents.find(e => e.day === day && e.month === (today.getMonth() + 1));
                    
                    if (hasEvent) {
                        el.classList.add('text-white', 'shadow-md', 'cursor-pointer', 'hover:scale-110');
                        el.classList.remove('text-gray-500', 'cursor-default');
                        
                        // Color Logic
                        if(hasEvent.type === 'deadline') el.classList.add('bg-red-500');
                        else if(hasEvent.type === 'meeting') el.classList.add('bg-blue-500');
                        else el.classList.add('bg-brand-green');
                        
                        el.title = hasEvent.title;
                    } else if(day === today.getDate()) {
                        el.classList.add('border-2', 'border-brand-blue', 'text-brand-blue');
                    }
                    this.grid.appendChild(el);
                }
            }
        }

        // --- LIGHTBOX LOGIC ---
        function openLightbox(type, src) {
            const lb = document.getElementById('lightbox');
            const content = document.getElementById('lightbox-content');
            lb.classList.remove('hidden');
            setTimeout(() => lb.classList.remove('opacity-0'), 10);
            document.body.style.overflow = 'hidden';

            if (type === 'video') {
                content.innerHTML = `<video controls autoplay class="max-w-full max-h-[85vh] shadow-2xl rounded-lg outline-none"><source src="${src}" type="video/mp4"></video>`;
            } else {
                content.innerHTML = `<img src="${src}" class="max-w-full max-h-[85vh] object-contain shadow-2xl rounded-lg">`;
            }
        }
        
        function closeLightbox() {
            const lb = document.getElementById('lightbox');
            lb.classList.add('opacity-0');
            setTimeout(() => {
                lb.classList.add('hidden');
                document.getElementById('lightbox-content').innerHTML = '';
                document.body.style.overflow = 'auto';
            }, 300);
        }

        // --- INIT ---
        document.addEventListener('DOMContentLoaded', () => {
            new HeroSlider();
            new EventCalendar();
        });
    </script>
</body>
</html>