<!DOCTYPE html>
<html lang="hy">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel | StudentBiz</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Armenian:wght@300;400;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script>
        tailwind.config = { theme: { extend: { colors: { brand: { blue: '#253894', green: '#63A900' } }, fontFamily: { sans: ['Noto Sans Armenian', 'Inter'] } } } }
    </script>
    <style>
        body { background-color: #f1f5f9; color: #334155; }
        .card { background: white; border-radius: 1rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; }
        .input-light { background: #f8fafc; border: 1px solid #cbd5e1; color: #1e293b; }
        .input-light:focus { border-color: #253894; background: white; outline: none; box-shadow: 0 0 0 3px rgba(37, 56, 148, 0.1); }
        .tab-content { display: none; } .tab-content.active { display: block; animation: fadeIn 0.3s; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(5px); } to { opacity: 1; transform: translateY(0); } }
        .nav-btn.active { background: #eff6ff; color: #253894; border-right: 3px solid #253894; font-weight: 600; }
    </style>
</head>
<body class="h-screen flex overflow-hidden">

    <aside class="w-72 bg-white border-r border-gray-200 hidden md:flex flex-col z-20">
        <div class="h-20 flex items-center px-6 border-b border-gray-100">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-brand-blue to-brand-green flex items-center justify-center text-white font-bold text-xl mr-3 shadow-lg">S</div>
            <div><span class="block font-bold text-gray-800 text-lg">Student<span class="text-brand-green">Biz</span></span><span class="block text-[11px] text-gray-400 uppercase font-bold">Admin Panel</span></div>
        </div>
        <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
            <div class="text-xs font-bold text-gray-400 uppercase px-4 mb-2 mt-2">Գլխավոր</div>
            <button onclick="switchTab('overview')" id="btn-overview" class="nav-btn w-full flex items-center gap-3 px-4 py-3 rounded-lg text-gray-600 text-left active"><i class="fas fa-chart-pie w-5 text-center"></i> <span>Վիճակագրություն</span></button>
            <button onclick="switchTab('applications')" id="btn-applications" class="nav-btn w-full flex items-center gap-3 px-4 py-3 rounded-lg text-gray-600 text-left"><i class="fas fa-file-signature w-5 text-center"></i> <span class="flex-1">Հայտեր</span><?php if($stats['apps']>0):?><span class="bg-brand-green text-white text-[10px] px-2 rounded-full"><?= $stats['apps'] ?></span><?php endif;?></button>
            <div class="text-xs font-bold text-gray-400 uppercase px-4 mb-2 mt-6">Կառավարում</div>
            <button onclick="switchTab('events')" id="btn-events" class="nav-btn w-full flex items-center gap-3 px-4 py-3 rounded-lg text-gray-600 text-left"><i class="fas fa-calendar-alt w-5 text-center"></i> Միջոցառումներ</button>
            <button onclick="switchTab('news')" id="btn-news" class="nav-btn w-full flex items-center gap-3 px-4 py-3 rounded-lg text-gray-600 text-left"><i class="fas fa-newspaper w-5 text-center"></i> Նորություններ</button>
            <button onclick="switchTab('gallery')" id="btn-gallery" class="nav-btn w-full flex items-center gap-3 px-4 py-3 rounded-lg text-gray-600 text-left"><i class="fas fa-photo-video w-5 text-center"></i> Տեսադարան</button>
        </nav>
        <div class="p-4 border-t border-gray-100 bg-gray-50">
            <a href="<?= $base ?>/logout" class="flex items-center gap-3 px-3 py-2 text-red-500 hover:bg-white rounded-lg transition group"><i class="fas fa-sign-out-alt w-5"></i> <span class="font-medium">Դուրս գալ</span></a>
        </div>
    </aside>

    <main class="flex-1 flex flex-col relative overflow-hidden bg-[#f1f5f9]">
        <div class="flex-1 overflow-y-auto p-6 md:p-10">
            
            <div id="tab-overview" class="tab-content active">
                <h1 class="text-3xl font-bold text-gray-800 mb-8">Բարի գալուստ, Admin</h1>
                <div class="grid grid-cols-4 gap-6 mb-8">
                    <div class="card p-6 border-t-4 border-brand-green"><p class="text-gray-400 text-xs font-bold uppercase">Միջոցառումներ</p><p class="text-4xl font-bold text-gray-800 mt-2"><?= $stats['events'] ?></p></div>
                    <div class="card p-6 border-t-4 border-brand-blue"><p class="text-gray-400 text-xs font-bold uppercase">Նորություններ</p><p class="text-4xl font-bold text-gray-800 mt-2"><?= $stats['news'] ?></p></div>
                    <div class="card p-6 border-t-4 border-purple-500"><p class="text-gray-400 text-xs font-bold uppercase">Մեդիա</p><p class="text-4xl font-bold text-gray-800 mt-2"><?= $stats['gallery'] ?></p></div>
                    <div class="card p-6 border-t-4 border-orange-500"><p class="text-gray-400 text-xs font-bold uppercase">Հայտեր</p><p class="text-4xl font-bold text-gray-800 mt-2"><?= $stats['apps'] ?></p></div>
                </div>
            </div>

            <div id="tab-applications" class="tab-content">
                <h1 class="text-2xl font-bold text-gray-800 mb-6">Ուսանողական Հայտեր</h1>
                <div class="card overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm whitespace-nowrap">
                            <thead class="bg-gray-50 text-gray-500 text-xs uppercase font-bold border-b border-gray-200"><tr><th class="p-4">ID</th><th class="p-4">Անուն</th><th class="p-4">Հաստատություն</th><th class="p-4">Գաղափար</th><th class="p-4">Ամսաթիվ</th><th class="p-4 text-right">Դիտել</th></tr></thead>
                            <tbody class="divide-y divide-gray-100">
                                <?php foreach ($applications as $app): ?>
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="p-4 text-gray-400 text-xs">#<?= $app['id'] ?></td>
                                    <td class="p-4 font-bold text-gray-800"><?= htmlspecialchars($app['full_name']) ?></td>
                                    <td class="p-4 text-gray-600"><?= htmlspecialchars($app['college']) ?></td>
                                    <td class="p-4 text-gray-500 truncate max-w-xs"><?= htmlspecialchars(mb_substr($app['idea'], 0, 30)) ?>...</td>
                                    <td class="p-4 text-gray-500 text-xs"><?= date('d.m.Y', strtotime($app['created_at'])) ?></td>
                                    <td class="p-4 text-right"><button onclick="viewApplication(<?= $app['id'] ?>)" class="text-brand-blue bg-blue-50 px-3 py-1.5 rounded-lg font-medium text-xs hover:bg-brand-blue hover:text-white transition"><i class="fas fa-eye mr-1"></i> Դիտել</button></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div id="tab-events" class="tab-content">
                <h1 class="text-2xl font-bold text-gray-800 mb-6">Միջոցառումներ</h1>
                <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
                    <div class="card p-6 h-fit">
                        <h3 class="font-bold mb-4 text-brand-green flex items-center gap-2"><i class="fas fa-plus-circle"></i> Ավելացնել նորը</h3>
                        <form action="<?= $base ?>/admin/events/add" method="POST" class="space-y-4">
                            <input type="text" name="title" placeholder="Անվանում" class="w-full input-light p-3 rounded-lg" required>
                            <input type="date" name="date" class="w-full input-light p-3 rounded-lg" required>
                            <select name="type" class="w-full input-light p-3 rounded-lg bg-white"><option value="event">Սովորական</option><option value="deadline">Վերջնաժամկետ</option><option value="meeting">Հանդիպում</option></select>
                            <button class="w-full bg-brand-green hover:bg-[#4d8500] text-white font-bold py-3 rounded-lg">Ստեղծել</button>
                        </form>
                    </div>
                    <div class="xl:col-span-2 card overflow-hidden">
                        <table class="w-full text-left text-sm"><thead class="bg-gray-50 text-gray-500 text-xs font-bold"><tr><th class="p-4">Ամսաթիվ</th><th class="p-4">Անվանում</th><th class="p-4">Տեսակ</th><th class="p-4 text-right">Գործողություն</th></tr></thead><tbody class="divide-y divide-gray-100"><?php foreach ($events as $e): ?><tr class="hover:bg-gray-50 transition"><td class="p-4 font-mono text-brand-green font-bold"><?= $e['event_date'] ?></td><td class="p-4 font-bold text-gray-700"><?= htmlspecialchars($e['title']) ?></td><td class="p-4 text-gray-500"><?= $e['type'] ?></td><td class="p-4 text-right"><a href="<?= $base ?>/admin/events/delete?id=<?= $e['id'] ?>" onclick="return confirm('Ջնջե՞լ')" class="text-gray-400 hover:text-red-500"><i class="fas fa-trash"></i></a></td></tr><?php endforeach; ?></tbody></table>
                    </div>
                </div>
            </div>

            <div id="tab-news" class="tab-content">
                <h1 class="text-2xl font-bold text-gray-800 mb-6">Նորություններ</h1>
                <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
                    <div class="card p-6 h-fit">
                        <h3 class="font-bold mb-4 text-brand-blue flex items-center gap-2"><i class="fas fa-pen"></i> Գրել նորություն</h3>
                        <form action="<?= $base ?>/admin/news/add" method="POST" enctype="multipart/form-data" class="space-y-4">
                            <input type="text" name="title" placeholder="Վերնագիր" class="w-full input-light p-3 rounded-lg" required>
                            <input type="date" name="date" class="w-full input-light p-3 rounded-lg" required>
                            <div class="relative border-2 border-dashed border-gray-300 rounded-lg p-4 hover:bg-blue-50 transition text-center cursor-pointer">
                                <input type="file" name="images[]" multiple accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" onchange="this.nextElementSibling.innerText = this.files.length + ' ֆայլ ընտրված է'">
                                <span class="text-gray-500 text-sm pointer-events-none"><i class="fas fa-cloud-upload-alt mr-2"></i> Ընտրել նկարներ (Multi)</span>
                            </div>
                            <textarea name="content" rows="4" placeholder="Տեքստ..." class="w-full input-light p-3 rounded-lg" required></textarea>
                            <button class="w-full bg-brand-blue hover:bg-blue-800 text-white font-bold py-3 rounded-lg">Հրապարակել</button>
                        </form>
                    </div>
                    <div class="xl:col-span-2 space-y-4">
                        <?php foreach ($news as $n): 
                            $imgs = json_decode($n['image_url'], true);
                            $thumb = is_array($imgs) ? $imgs[0] : $n['image_url'];
                        ?>
                        <div class="card p-4 flex gap-4 items-start group hover:shadow-md transition">
                            <img src="<?= htmlspecialchars($thumb) ?>" class="w-24 h-24 object-cover rounded-lg bg-gray-200">
                            <div class="flex-1"><h4 class="font-bold text-gray-800 text-lg group-hover:text-brand-blue transition"><?= htmlspecialchars($n['title']) ?></h4><p class="text-xs text-gray-400 mb-2"><?= $n['publish_date'] ?></p></div>
                            <a href="<?= $base ?>/admin/news/delete?id=<?= $n['id'] ?>" onclick="return confirm('Ջնջե՞լ')" class="text-gray-400 hover:text-red-500 p-2"><i class="fas fa-trash text-lg"></i></a>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div id="tab-gallery" class="tab-content">
                <h1 class="text-2xl font-bold text-gray-800 mb-6">Տեսադարան</h1>
                <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
                    <div class="card p-6 h-fit">
    <h3 class="font-bold mb-4 text-purple-600 flex items-center gap-2">
        <i class="fas fa-upload"></i> Ստեղծել Ալբոմ (Фото/Видео)
    </h3>
    <form action="<?= $base ?>/admin/gallery/add" method="POST" enctype="multipart/form-data" class="space-y-4">
        
        <input type="text" name="caption" placeholder="Ալբոմի վերնագիր" class="w-full input-light p-3 rounded-lg" required>
        
        <div class="relative border-2 border-dashed border-purple-300 bg-purple-50 rounded-lg p-6 hover:bg-purple-100 transition text-center cursor-pointer group">
            <input type="file" name="media[]" multiple accept="image/*,video/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" onchange="this.nextElementSibling.innerHTML = '<i class=\'fas fa-check-circle text-green-600\'></i> ' + this.files.length + ' ֆայլ պատրաստ է'">
            <div class="text-purple-500 pointer-events-none group-hover:scale-105 transition-transform">
                <i class="fas fa-cloud-upload-alt text-3xl mb-2"></i>
                <p class="text-sm font-bold">Ընտրել ֆայլեր</p>
                <p class="text-xs text-gray-400">(JPG, PNG, MP4)</p>
            </div>
        </div>

        <div class="text-xs text-gray-400 text-center">Կարող եք միաժամանակ ընտրել նկարներ և տեսանյութեր</div>

        <button class="w-full bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 rounded-lg transition shadow-md hover:shadow-lg">
            Ավելացնել
        </button>
    </form>
</div>
                    <div class="xl:col-span-2 grid grid-cols-2 md:grid-cols-3 gap-4">
                        <?php foreach ($gallery as $g): ?>
                        <div class="card rounded-lg overflow-hidden relative group aspect-video shadow-sm hover:shadow-xl transition-all">
                            <img src="<?= htmlspecialchars($g['media_url']) ?>" class="w-full h-full object-cover">
                            <div class="absolute bottom-0 left-0 w-full p-2 bg-gradient-to-t from-black/70 to-transparent"><p class="text-xs font-bold text-white truncate"><?= htmlspecialchars($g['caption']) ?></p></div>
                            <a href="<?= $base ?>/admin/gallery/delete?id=<?= $g['id'] ?>" onclick="return confirm('Ջնջե՞լ')" class="absolute top-2 right-2 bg-white text-red-500 w-8 h-8 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition shadow-lg hover:bg-red-500 hover:text-white"><i class="fas fa-times text-sm"></i></a>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <div id="app-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4 overflow-y-auto">
        <div class="bg-white w-full max-w-4xl rounded-2xl shadow-2xl flex flex-col my-auto relative">
            <div class="p-6 border-b border-gray-100 flex justify-between items-start bg-gray-50 rounded-t-2xl">
                <div><h2 class="text-2xl font-bold text-brand-blue" id="modal-name">Loading...</h2><p class="text-brand-green font-bold mt-1 text-lg" id="modal-college">...</p><div class="flex gap-4 mt-2 text-sm text-gray-500 font-medium"><span id="modal-date" class="bg-gray-200 px-2 py-0.5 rounded">...</span><span id="modal-email-display">...</span></div></div>
                <button onclick="closeAppModal()" class="w-10 h-10 rounded-full bg-gray-200 text-gray-500 hover:bg-red-500 hover:text-white transition flex items-center justify-center"><i class="fas fa-times text-lg"></i></button>
            </div>
            <div class="p-8 space-y-8 overflow-y-auto max-h-[80vh]">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="card p-5 border-l-4 border-brand-blue bg-blue-50/30"><h3 class="text-brand-blue font-bold mb-4 text-lg"><i class="fas fa-school"></i> Հաստատություն</h3><div class="space-y-3 text-sm"><div><span class="text-gray-400 text-xs uppercase font-bold">Հասցե</span> <span class="text-gray-800 font-medium" id="val-address">-</span></div><div><span class="text-gray-400 text-xs uppercase font-bold">Տնօրեն</span> <span class="text-gray-800 font-bold" id="val-director">-</span></div></div></div>
                    <div class="card p-5 border-l-4 border-brand-green bg-green-50/30"><h3 class="text-brand-green font-bold mb-4 text-lg"><i class="fas fa-chalkboard-teacher"></i> Մենթոր</h3><div class="space-y-3 text-sm"><div><span class="text-gray-400 text-xs uppercase font-bold">Անուն</span> <span class="text-gray-800 font-bold" id="val-mentor">-</span></div><div><span class="text-gray-400 text-xs uppercase font-bold">Կոնտակտ</span> <span class="text-gray-600" id="val-mentor-contact">-</span></div></div></div>
                </div>
                <div><h3 class="text-xl font-bold text-gray-800 mb-4 border-b border-gray-100 pb-2">Թիմի Կազմը</h3><div class="card overflow-hidden"><table class="w-full text-left text-sm"><thead class="bg-gray-50 text-gray-500 text-xs uppercase font-bold"><tr><th class="p-3">#</th><th class="p-3">Անուն</th><th class="p-3">Դասարան</th><th class="p-3">Դեր</th></tr></thead><tbody class="divide-y divide-gray-100" id="modal-team-body"></tbody></table></div></div>
                <div class="space-y-6"><h3 class="text-xl font-bold text-gray-800 border-b border-gray-100 pb-2">Ծրագրի Մանրամասներ</h3><div class="card p-6 bg-yellow-50/50 border border-yellow-100"><span class="text-orange-500 font-bold text-xs uppercase tracking-wider mb-2 block">Բիզնես Գաղափար</span><p class="text-gray-800 leading-relaxed whitespace-pre-wrap text-lg font-medium" id="val-idea">...</p></div><div class="grid grid-cols-1 md:grid-cols-2 gap-6"><div class="card p-5"><span class="text-gray-400 font-bold text-xs uppercase mb-2 block">Նպատակներ</span><p class="text-gray-700 text-sm whitespace-pre-wrap" id="val-goals">-</p></div><div class="card p-5"><span class="text-gray-400 font-bold text-xs uppercase mb-2 block">Ռեսուրսներ</span><p class="text-gray-700 text-sm whitespace-pre-wrap" id="val-resources">-</p></div></div></div>
            </div>
            <div class="p-4 border-t border-gray-100 bg-gray-50 rounded-b-2xl flex justify-end"><button onclick="closeAppModal()" class="bg-white border border-gray-300 hover:bg-gray-100 text-gray-700 px-8 py-2.5 rounded-lg transition font-bold shadow-sm">Փակել</button></div>
        </div>
    </div>

    <script>
        function switchTab(name) {
            if(!document.getElementById('tab-'+name)) return;
            document.querySelectorAll('.tab-content').forEach(el => el.classList.remove('active'));
            document.querySelectorAll('.nav-btn').forEach(el => el.classList.remove('active'));
            document.getElementById('tab-'+name).classList.add('active');
            document.getElementById('btn-'+name).classList.add('active');
            const url = new URL(window.location); url.searchParams.set('tab', name); window.history.pushState({}, '', url);
        }
        const currentTab = new URLSearchParams(window.location.search).get('tab');
        if (currentTab) switchTab(currentTab);

        const modal = document.getElementById('app-modal');
        async function viewApplication(id) {
            modal.classList.remove('hidden'); document.body.style.overflow = 'hidden';
            document.getElementById('modal-name').innerText = 'Loading...';
            try {
                const res = await fetch('<?= $base ?>/admin/applications/get?id=' + id);
                const json = await res.json();
                if(json.status === 'success') {
                    const d = json.data;
                    document.getElementById('modal-name').innerText = d.full_name;
                    document.getElementById('modal-college').innerText = d.college;
                    document.getElementById('modal-date').innerText = d.created_at;
                    document.getElementById('modal-email-display').innerText = d.email;
                    document.getElementById('val-idea').innerText = d.idea;
                    
                    let x = {}; try { x = JSON.parse(d.full_data || '{}'); } catch(e){}
                    const set = (id, t) => { const e = document.getElementById(id); if(e) e.innerText = t || '-'; };
                    
                    set('val-address', x.address); set('val-director', x.director_name);
                    set('val-mentor', x.mentor_name); set('val-mentor-contact', (x.mentor_phone||'')+' '+(x.mentor_email||''));
                    set('val-goals', x.goals); set('val-resources', x.resources);

                    const tbody = document.getElementById('modal-team-body'); tbody.innerHTML = '';
                    const members = [];
                    for(const k in x) { if(k.startsWith('team_name_')) { const i = k.split('_').pop(); members.push({name:x[k], class:x['team_class_'+i], role:x['team_role_'+i]}); } }
                    
                    if(members.length === 0) tbody.innerHTML = '<tr><td colspan="4" class="p-4 text-center text-gray-400">Թիմ նշված չէ</td></tr>';
                    members.forEach((m, i) => {
                        tbody.innerHTML += `<tr class="border-b border-gray-50"><td class="p-3 text-gray-400 text-xs">${i+1}</td><td class="p-3 font-bold">${m.name||'-'}</td><td class="p-3 text-gray-500">${m.class||'-'}</td><td class="p-3 text-brand-blue">${m.role||'-'}</td></tr>`;
                    });
                }
            } catch(e) { alert('Error'); closeAppModal(); }
        }
        function closeAppModal() { modal.classList.add('hidden'); document.body.style.overflow = 'auto'; }
    </script>
</body>
</html>