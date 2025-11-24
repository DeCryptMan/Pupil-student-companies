<?php
// БАЗОВАЯ КОНФИГУРАЦИЯ
$scriptName = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
$base_url = ($scriptName === '/') ? '' : $scriptName;

// Простая проверка для ссылок (якорь или полная ссылка)
$is_home = ($_SERVER['REQUEST_URI'] == $base_url . '/' || $_SERVER['REQUEST_URI'] == $base_url . '/index.php');
?>

<div class="h-20 w-full"></div>

<nav class="fixed top-0 left-0 w-full h-20 bg-white border-b border-gray-200 z-[999] shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full">
        <div class="flex justify-between items-center h-full">
            
            <a href="<?= $base_url ?>/" class="flex-shrink-0 py-2">
                <img src="<?= $base_url ?>/uploads/logo.webp" 
                     alt="Logo" 
                     width="120" 
                     height="50"
                     class="h-12 w-auto object-contain">
            </a>
            
            <div class="hidden md:flex items-center space-x-8">
                <nav class="flex space-x-6">
                    <?php
                    $menuItems = [
                        ['news', 'Նորություններ'],
                        ['calendar', 'Միջոցառումներ'],
                        ['gallery', 'Տեսադարան'],
                    ];

                    foreach ($menuItems as $item):
                        $link = $is_home ? "#{$item[0]}" : "$base_url/#{$item[0]}";
                    ?>
                        <a href="<?= $link ?>" class="text-[15px] font-medium text-gray-700 hover:text-brand-blue transition-colors duration-200">
                            <?= $item[1] ?>
                        </a>
                    <?php endforeach; ?>
                </nav>

                <div class="h-6 w-px bg-gray-300"></div>

                <a href="<?= $base_url ?>/apply" 
                   class="bg-brand-blue text-white px-6 py-2.5 rounded-lg font-semibold text-sm hover:bg-brand-green transition-colors duration-300 shadow-sm flex items-center gap-2">
                    Ուղարկել Հայտ
                    <i class="fas fa-arrow-right text-xs"></i>
                </a>
            </div>

            <div class="md:hidden flex items-center">
                <button id="mobile-menu-btn" class="p-2 rounded-md text-gray-600 hover:text-brand-blue hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-brand-blue">
                    <i class="fas fa-bars text-2xl" id="menu-icon"></i>
                </button>
            </div>
        </div>
    </div>

    <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-gray-100 absolute w-full left-0 top-20 shadow-lg">
        <div class="px-4 pt-2 pb-6 space-y-2">
            <?php foreach ($menuItems as $item): 
                $link = $is_home ? "#{$item[0]}" : "$base_url/#{$item[0]}";
            ?>
                <a href="<?= $link ?>" class="mobile-link block px-3 py-3 rounded-md text-base font-medium text-gray-700 hover:text-brand-blue hover:bg-blue-50">
                    <?= $item[1] ?>
                </a>
            <?php endforeach; ?>
            
            <div class="border-t border-gray-100 my-2 pt-2"></div>
            
            <a href="<?= $base_url ?>/apply" class="block w-full text-center px-4 py-3 mt-4 rounded-lg bg-brand-blue text-white font-bold hover:bg-brand-green">
                Հայտ ուղարկել
            </a>
        </div>
    </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const btn = document.getElementById('mobile-menu-btn');
    const menu = document.getElementById('mobile-menu');
    const icon = document.getElementById('menu-icon');
    let isOpen = false;

    // Функция переключения меню
    function toggleMenu() {
        isOpen = !isOpen;
        if (isOpen) {
            menu.classList.remove('hidden');
            icon.classList.remove('fa-bars');
            icon.classList.add('fa-times');
        } else {
            menu.classList.add('hidden');
            icon.classList.remove('fa-times');
            icon.classList.add('fa-bars');
        }
    }

    // Клик по кнопке
    btn.addEventListener('click', (e) => {
        e.stopPropagation(); // Чтобы клик по кнопке не закрывал меню сразу же (если добавим клик вне)
        toggleMenu();
    });

    // Закрытие меню при клике на ссылку
    const links = menu.querySelectorAll('a');
    links.forEach(link => {
        link.addEventListener('click', () => {
            if (isOpen) toggleMenu();
        });
    });
    
    // Закрытие при клике вне меню (для удобства)
    document.addEventListener('click', (e) => {
        if (isOpen && !menu.contains(e.target) && !btn.contains(e.target)) {
            toggleMenu();
        }
    });
});
</script>