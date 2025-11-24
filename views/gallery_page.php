<?php
// 1. Configuration
$scriptName = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
$base_url = ($scriptName === '/') ? '' : $scriptName;
?>
<!DOCTYPE html>
<html lang="hy">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Տեսադարան | StudentBiz Ecosystem</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:wght@600;700;800&family=Noto+Sans+Armenian:wght@400;500;700&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            blue: '#253894',
                            green: '#63A900',
                            dark: '#0f172a',
                            surface: '#ffffff'
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'Noto Sans Armenian', 'sans-serif'],
                        serif: ['Playfair Display', 'serif'],
                    },
                    boxShadow: {
                        'premium': '0 25px 50px -12px rgba(37, 56, 148, 0.15)',
                        'card': '0 4px 6px -1px rgba(0, 0, 0, 0.02), 0 2px 4px -1px rgba(0, 0, 0, 0.02)'
                    }
                }
            }
        }
    </script>

    <style>
        /* GLOBAL RESET */
        body { background-color: #ffffff; color: #1e293b; overflow-x: hidden; }
        
        /* HIDE SCROLLBARS (Clean UI) */
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
        
        /* ANIMATIONS */
        .fade-in-up { animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; transform: translateY(30px); }
        @keyframes fadeInUp { to { opacity: 1; transform: translateY(0); } }
        
        .reveal-image { transition: transform 0.7s cubic-bezier(0.25, 0.46, 0.45, 0.94); }
        .group:hover .reveal-image { transform: scale(1.03); }
        
        /* CONTROLS */
        .slider-btn { opacity: 0; transition: all 0.3s ease; transform: scale(0.9); }
        .group:hover .slider-btn { opacity: 1; transform: scale(1); }
    </style>
</head>
<body class="flex flex-col min-h-screen selection:bg-brand-green selection:text-white">

    <?php include __DIR__ . '/partials/navbar.php'; ?>

    <header class="pt-40 pb-20 bg-white relative overflow-hidden">
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[1000px] h-[500px] bg-gradient-to-b from-blue-50/50 to-transparent rounded-full blur-3xl -z-10"></div>

        <div class="max-w-7xl mx-auto px-4 text-center z-10 relative">
            <span class="inline-block py-1 px-3 rounded-full bg-brand-blue/5 text-brand-blue text-xs font-bold tracking-widest uppercase mb-6 border border-brand-blue/10 fade-in-up" style="animation-delay: 0.1s;">
                Our Legacy
            </span>
            <h1 class="text-6xl md:text-7xl font-serif font-bold text-brand-blue mb-6 fade-in-up" style="animation-delay: 0.2s;">
                Մեր Ձեռքբերումները
            </h1>
            <p class="text-lg text-gray-500 max-w-2xl mx-auto font-light leading-relaxed fade-in-up" style="animation-delay: 0.3s;">
                Բացահայտեք մեր ուսանողների հաջողության պատմությունները, միջոցառումները և լավագույն պահերը լուսանկարների և տեսանյութերի միջոցով:
            </p>

            <div class="mt-12 inline-flex bg-gray-100 p-1.5 rounded-full fade-in-up" style="animation-delay: 0.4s;">
                <button class="filter-btn active px-8 py-3 rounded-full text-sm font-bold transition-all duration-300 text-brand-blue bg-white shadow-md" data-filter="all">
                    Բոլորը
                </button>
                <button class="filter-btn px-8 py-3 rounded-full text-sm font-bold transition-all duration-300 text-gray-500 hover:text-brand-blue" data-filter="photo">
                    <i class="fas fa-camera mr-2"></i> Լուսանկար
                </button>
                <button class="filter-btn px-8 py-3 rounded-full text-sm font-bold transition-all duration-300 text-gray-500 hover:text-brand-blue" data-filter="video">
                    <i class="fas fa-video mr-2"></i> Տեսանյութ
                </button>
            </div>
        </div>
    </header>

    <main class="flex-1 max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-8 pb-24 w-full">
        
        <?php if (empty($gallery)): ?>
            <div class="flex flex-col items-center justify-center py-32 border-2 border-dashed border-gray-100 rounded-3xl bg-gray-50/50">
                <i class="fas fa-layer-group text-6xl text-gray-200 mb-4"></i>
                <h3 class="text-xl font-bold text-gray-400">Տեսադարանը դատարկ է</h3>
            </div>
        <?php else: ?>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="gallery-grid">
                
                <?php foreach ($gallery as $index => $media): 
                    // --- LOGIC CORE ---
                    // 1. Parse JSON safely
                    $content = json_decode($media['media_url'], true);
                    if (!is_array($content)) {
                        $content = [['type' => $media['type'], 'url' => $media['media_url']]];
                    }
                    
                    // 2. Unique ID for slider
                    $uid = 'gal-' . $media['id'];
                    $count = count($content);
                    
                    // 3. Determine Filter Category (Mixed = All)
                    $cat = ($media['type'] === 'mixed') ? 'all' : $media['type'];
                ?>
                
                <div class="gallery-item group relative aspect-[4/3] rounded-2xl bg-gray-100 overflow-hidden shadow-card hover:shadow-premium transition-all duration-500 border border-gray-100/50 fade-in-up"
                     style="animation-delay: <?= 0.1 * ($index % 5) ?>s;"
                     data-category="<?= $cat ?>">
                    
                    <?php if ($count > 1): ?>
                        <div class="w-full h-full flex overflow-x-auto snap-x snap-mandatory scrollbar-hide relative z-0" id="<?= $uid ?>">
                            <?php foreach ($content as $item): 
                                $src = (strpos($item['url'], 'http') === 0) ? $item['url'] : $base_url . '/' . ltrim($item['url'], '/');
                            ?>
                                <div class="w-full h-full flex-shrink-0 snap-center relative bg-gray-200">
                                    <?php if ($item['type'] === 'video'): ?>
                                        <video src="<?= htmlspecialchars($src) ?>" class="w-full h-full object-cover" muted loop playsinline onmouseover="this.play()" onmouseout="this.pause()"></video>
                                        <div class="absolute inset-0 flex items-center justify-center pointer-events-none bg-black/10">
                                            <div class="w-12 h-12 bg-white/20 backdrop-blur-md rounded-full flex items-center justify-center border border-white/30">
                                                <i class="fas fa-play text-white pl-1"></i>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <img src="<?= htmlspecialchars($src) ?>" class="w-full h-full object-cover reveal-image" loading="lazy">
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <div class="absolute inset-0 flex items-center justify-between px-4 pointer-events-none z-20">
                            <button onclick="document.getElementById('<?= $uid ?>').scrollBy({left: -400, behavior: 'smooth'})" class="slider-btn pointer-events-auto w-10 h-10 rounded-full bg-white/90 text-brand-blue shadow-lg flex items-center justify-center hover:bg-brand-blue hover:text-white transition">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <button onclick="document.getElementById('<?= $uid ?>').scrollBy({left: 400, behavior: 'smooth'})" class="slider-btn pointer-events-auto w-10 h-10 rounded-full bg-white/90 text-brand-blue shadow-lg flex items-center justify-center hover:bg-brand-blue hover:text-white transition">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>
                        
                        <div class="absolute top-4 right-4 z-20 bg-black/60 backdrop-blur-md text-white text-[10px] font-bold px-3 py-1.5 rounded-full flex items-center gap-2 shadow-lg border border-white/10">
                            <i class="fas fa-layer-group"></i> <span>1 / <?= $count ?></span>
                        </div>

                    <?php else: ?>
                        <?php 
                            $first = $content[0]; 
                            $src = (strpos($first['url'], 'http') === 0) ? $first['url'] : $base_url . '/' . ltrim($first['url'], '/');
                        ?>
                        <div class="w-full h-full cursor-pointer" onclick="openLightbox('<?= $first['type'] ?>', '<?= htmlspecialchars($src) ?>')">
                            <?php if ($first['type'] === 'video'): ?>
                                <video src="<?= htmlspecialchars($src) ?>" class="w-full h-full object-cover" muted loop playsinline onmouseover="this.play()" onmouseout="this.pause()"></video>
                                <div class="absolute top-4 right-4 z-20 bg-white/90 backdrop-blur text-brand-blue text-[10px] font-bold px-3 py-1 rounded-full shadow-lg uppercase tracking-wider">Video</div>
                                <div class="absolute inset-0 flex items-center justify-center pointer-events-none group-hover:scale-110 transition-transform duration-500">
                                    <div class="w-16 h-16 bg-white/20 backdrop-blur-md rounded-full flex items-center justify-center border border-white/30 shadow-2xl">
                                        <i class="fas fa-play text-white text-xl pl-1"></i>
                                    </div>
                                </div>
                            <?php else: ?>
                                <img src="<?= htmlspecialchars($src) ?>" class="w-full h-full object-cover reveal-image" loading="lazy">
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <div class="absolute bottom-0 left-0 w-full p-6 bg-gradient-to-t from-black/90 via-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-500 z-10 flex flex-col justify-end h-1/2">
                        <div class="transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500 delay-75">
                            <p class="text-brand-green text-[10px] font-bold uppercase tracking-widest mb-1">StudentBiz Gallery</p>
                            <h3 class="text-white font-bold text-lg leading-snug drop-shadow-md"><?= htmlspecialchars($media['caption']) ?></h3>
                        </div>
                    </div>

                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>

    <footer class="bg-brand-blue text-white py-12 border-t border-white/10">
        <div class="max-w-7xl mx-auto px-4 flex flex-col items-center">
            <div class="w-10 h-10 rounded-xl bg-white text-brand-blue flex items-center justify-center font-bold text-xl mb-4 shadow-lg">S</div>
            <span class="font-serif text-2xl font-bold mb-2">StudentBiz</span>
            <p class="text-blue-200 text-sm opacity-80">&copy; 2025 All rights reserved.</p>
        </div>
    </footer>

    <div id="lightbox" class="hidden fixed inset-0 z-[100] bg-[#050505]/95 backdrop-blur-xl transition-all duration-500 opacity-0 flex items-center justify-center" onclick="closeLightbox()">
        
        <button class="absolute top-8 right-8 text-white/50 hover:text-white transition transform hover:rotate-90 duration-300 z-50">
            <i class="fas fa-times text-4xl"></i>
        </button>

        <div class="relative w-full h-full max-w-[90vw] max-h-[90vh] flex items-center justify-center p-4" onclick="event.stopPropagation()">
             <div id="lightbox-content" class="rounded-lg overflow-hidden shadow-[0_0_100px_rgba(0,0,0,0.8)] ring-1 ring-white/10">
                 </div>
        </div>
    </div>

    <script>
        // --- 1. FILTER ENGINE ---
        const filterBtns = document.querySelectorAll('.filter-btn');
        const items = document.querySelectorAll('.gallery-item');

        filterBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                // Style Reset
                filterBtns.forEach(b => {
                    b.classList.remove('active', 'bg-brand-blue', 'text-white', 'shadow-md');
                    b.classList.add('text-gray-500');
                });
                // Active Style
                btn.classList.add('active', 'bg-brand-blue', 'text-white', 'shadow-md');
                btn.classList.remove('text-gray-500');

                // Filter Logic
                const filter = btn.dataset.filter;
                items.forEach(item => {
                    const cat = item.dataset.category;
                    // Mixed albums show in all filters
                    if (filter === 'all' || cat === filter || cat === 'mixed') {
                        item.classList.remove('hidden');
                        // Re-trigger fade animation
                        item.style.animation = 'none';
                        item.offsetHeight; /* trigger reflow */
                        item.style.animation = 'fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards';
                    } else {
                        item.classList.add('hidden');
                    }
                });
            });
        });

        // --- 2. LIGHTBOX ENGINE ---
        const lightbox = document.getElementById('lightbox');
        const content = document.getElementById('lightbox-content');

        function openLightbox(type, src) {
            lightbox.classList.remove('hidden');
            setTimeout(() => lightbox.classList.remove('opacity-0'), 10);
            document.body.style.overflow = 'hidden'; // Lock scroll

            if (type === 'video') {
                content.innerHTML = `
                    <video controls autoplay class="max-w-full max-h-[85vh] outline-none bg-black">
                        <source src="${src}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>`;
            } else {
                content.innerHTML = `<img src="${src}" class="max-w-full max-h-[85vh] object-contain bg-black">`;
            }
        }
        
        function closeLightbox() {
            lightbox.classList.add('opacity-0');
            setTimeout(() => {
                lightbox.classList.add('hidden');
                content.innerHTML = '';
                document.body.style.overflow = 'auto';
            }, 500);
        }

        // --- 3. KEYBOARD SUPPORT ---
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeLightbox();
        });
    </script>
</body>
</html>