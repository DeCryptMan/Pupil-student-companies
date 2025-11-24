<!DOCTYPE html>
<html lang="hy">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Հայտադիմում | StudentBiz</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Armenian:wght@400;600;700&family=Inter:wght@400;600&display=swap" rel="stylesheet">
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: { blue: '#253894', green: '#63A900', light: '#F3F4F6' }
                    },
                    fontFamily: { sans: ['Noto Sans Armenian', 'sans-serif'] },
                    boxShadow: { 'card': '0 10px 30px -5px rgba(37, 56, 148, 0.1)' }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 text-gray-800">

 <?php include __DIR__ . '/partials/navbar.php'; ?>
    <main class="max-w-4xl mx-auto px-4 py-12">
        
        <div class="text-center mb-12">
            <h1 class="text-3xl md:text-4xl font-bold text-brand-blue mb-2">ՀԱՅՏԱԴԻՄՈՒՄԻ ՁԵՎ</h1>
            <p class="text-gray-500 text-lg">Մրցույթ․ Աշակերտական/Ուսանողական ընկերությունների ստեղծում</p>
            <div class="w-24 h-1.5 bg-brand-green mx-auto rounded-full mt-6"></div>
        </div>

        <form id="applicationForm" class="space-y-8">

            <section class="bg-white rounded-2xl shadow-card p-8 border-t-4 border-brand-blue relative overflow-hidden group hover:shadow-2xl transition-all duration-300">
                <div class="absolute top-0 right-0 w-24 h-24 bg-blue-50 rounded-bl-full -mr-12 -mt-12 transition group-hover:bg-blue-100"></div>
                <h2 class="text-2xl font-bold text-brand-blue mb-6 flex items-center"><span class="w-8 h-8 rounded-full bg-brand-blue text-white text-sm flex items-center justify-center mr-3">I</span> ԸՆԴՀԱՆՈՒՐ ՏՎՅԱԼՆԵՐ</h2>
                
                <div class="space-y-6">
                    <div>
                        <label class="block font-semibold text-gray-700 mb-2">1. Կրթական հաստատության անվանումը</label>
                        <input type="text" name="school_name" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-brand-blue focus:ring-2 focus:ring-blue-100 outline-none transition" placeholder="Օրինակ՝ Երևանի N1 ավագ դպրոց">
                    </div>
                    <div>
                        <label class="block font-semibold text-gray-700 mb-2">2. Հասցե, մարզ, համայնք</label>
                        <input type="text" name="address" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-brand-blue focus:ring-2 focus:ring-blue-100 outline-none transition">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4">
                        <div class="bg-gray-50 p-5 rounded-xl border border-gray-100">
                            <h3 class="font-bold text-gray-800 mb-4 border-b pb-2">3. Կոնտակտային անձ (Մենթոր)</h3>
                            <div class="space-y-3">
                                <input type="text" name="mentor_name" placeholder="Անուն, ազգանուն" class="w-full px-3 py-2 rounded border focus:border-brand-blue outline-none">
                                <input type="text" name="mentor_position" placeholder="Պաշտոն" class="w-full px-3 py-2 rounded border focus:border-brand-blue outline-none">
                                <input type="tel" name="mentor_phone" placeholder="Հեռախոս" class="w-full px-3 py-2 rounded border focus:border-brand-blue outline-none">
                                <input type="email" name="mentor_email" placeholder="Էլ․ փոստ" class="w-full px-3 py-2 rounded border focus:border-brand-blue outline-none">
                            </div>
                        </div>

                        <div class="bg-gray-50 p-5 rounded-xl border border-gray-100">
                            <h3 class="font-bold text-gray-800 mb-4 border-b pb-2">4. Հաստատության ղեկավար</h3>
                            <div class="space-y-3">
                                <input type="text" name="director_name" placeholder="Անուն, ազգանուն" class="w-full px-3 py-2 rounded border focus:border-brand-blue outline-none">
                                <input type="tel" name="director_phone" placeholder="Հեռախոս" class="w-full px-3 py-2 rounded border focus:border-brand-blue outline-none">
                                <input type="email" name="director_email" placeholder="Էլ․ փոստ" class="w-full px-3 py-2 rounded border focus:border-brand-blue outline-none">
                            </div>
                        </div>
                    </div>

                    <div class="pt-4">
                        <label class="block font-semibold text-gray-700 mb-3">5. Ուսումնական հաստատության տեսակը</label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <label class="flex items-center p-3 border rounded-lg hover:bg-gray-50 cursor-pointer transition">
                                <input type="radio" name="school_type" value="main" class="w-5 h-5 text-brand-green focus:ring-brand-green">
                                <span class="ml-2">Հիմնական դպրոց</span>
                            </label>
                            <label class="flex items-center p-3 border rounded-lg hover:bg-gray-50 cursor-pointer transition">
                                <input type="radio" name="school_type" value="high" class="w-5 h-5 text-brand-green focus:ring-brand-green">
                                <span class="ml-2">Ավագ դպրոց</span>
                            </label>
                            <label class="flex items-center p-3 border rounded-lg hover:bg-gray-50 cursor-pointer transition">
                                <input type="radio" name="school_type" value="middle" class="w-5 h-5 text-brand-green focus:ring-brand-green">
                                <span class="ml-2">Միջնակարգ դպրոց</span>
                            </label>
                            <label class="flex items-center p-3 border rounded-lg hover:bg-gray-50 cursor-pointer transition">
                                <input type="radio" name="school_type" value="vocational" class="w-5 h-5 text-brand-green focus:ring-brand-green">
                                <span class="ml-2">ՄԿՈւ հաստատություն</span>
                            </label>
                        </div>
                    </div>
                </div>
            </section>

            <section class="bg-white rounded-2xl shadow-card p-8 border-t-4 border-brand-green relative overflow-hidden">
                <h2 class="text-2xl font-bold text-brand-blue mb-6 flex items-center"><span class="w-8 h-8 rounded-full bg-brand-green text-white text-sm flex items-center justify-center mr-3">II</span> ԹԻՄԻ ԿԱԶՄԸ</h2>
                
                <div class="mb-4">
                    <label class="block font-semibold text-gray-700 mb-2">Աշակերտների / ուսանողների թիվը</label>
                    <input type="number" id="team_count" class="w-24 px-4 py-2 rounded-lg border border-gray-300 focus:border-brand-green outline-none" readonly value="1">
                </div>

                <div class="overflow-x-auto rounded-lg border border-gray-200">
                    <table class="w-full text-left text-sm" id="teamTable">
                        <thead class="bg-gray-100 text-gray-700 uppercase font-bold">
                            <tr>
                                <th class="p-4 w-10">№</th>
                                <th class="p-4">Անուն, Ազգանուն</th>
                                <th class="p-4">Դասարան / Կուրս</th>
                                <th class="p-4">Դերը թիմում</th>
                                <th class="p-4 w-10"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200" id="teamRows">
                            </tbody>
                    </table>
                </div>
                
                <button type="button" id="addMemberBtn" class="mt-4 flex items-center text-brand-green font-bold hover:text-green-700 transition">
                    <i class="fas fa-plus-circle mr-2 text-xl"></i> Ավելացնել անդամ
                </button>
            </section>

            <section class="bg-white rounded-2xl shadow-card p-8 border-t-4 border-brand-blue">
                <h2 class="text-2xl font-bold text-brand-blue mb-6 flex items-center"><span class="w-8 h-8 rounded-full bg-brand-blue text-white text-sm flex items-center justify-center mr-3">III</span> ԳԱՂԱՓԱՐԻ ՆԿԱՐԱԳՐՈՒԹՅՈՒՆ</h2>
                
                <div class="space-y-6">
                    <div>
                        <label class="block font-semibold text-gray-700 mb-2">1. Ընկերության անվանումը (առաջարկվող)</label>
                        <input type="text" name="company_name" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-brand-blue outline-none transition">
                    </div>

                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <label class="block font-semibold text-gray-700">2. Գաղափարի համառոտ նկարագիր</label>
                            <span class="text-xs text-gray-400" id="wordCount">0 / 200 բառ</span>
                        </div>
                        <textarea name="idea_desc" id="ideaDesc" rows="4" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-brand-blue outline-none transition" placeholder="Նկարագրեք ձեր բիզնես գաղափարը..."></textarea>
                    </div>

                    <div>
                        <label class="block font-semibold text-gray-700 mb-3">3. Գործունեության ուղղությունը</label>
                        <select name="direction" id="directionSelect" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-brand-blue outline-none bg-white">
                            <option value="">Ընտրել ուղղությունը</option>
                            <option value="production">Արտադրություն</option>
                            <option value="service">Ծառայություններ</option>
                            <option value="social">Սոցիալական ձեռնարկատիրություն</option>
                            <option value="green">Կանաչ / էկոլոգիական</option>
                            <option value="other">Այլ</option>
                        </select>
                        <input type="text" name="direction_other" id="directionOther" class="w-full mt-3 px-4 py-3 rounded-lg border border-gray-300 focus:border-brand-blue outline-none hidden" placeholder="Նշեք ուղղությունը">
                    </div>

                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label class="block font-semibold text-gray-700 mb-2">4. Նպատակ և ակնկալվող արդյունքներ</label>
                            <textarea name="goals" rows="3" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-brand-blue outline-none"></textarea>
                        </div>
                        <div>
                            <label class="block font-semibold text-gray-700 mb-2">5. Հիմնական օգտատերեր և շահառուներ</label>
                            <textarea name="users" rows="3" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-brand-blue outline-none"></textarea>
                        </div>
                        <div>
                            <label class="block font-semibold text-gray-700 mb-2">6. Ակնկալվող ազդեցություն (սոցիալական/էկոլոգիական)</label>
                            <textarea name="impact" rows="3" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-brand-blue outline-none"></textarea>
                        </div>
                    </div>
                </div>
            </section>

             <section class="bg-white rounded-2xl shadow-card p-8 border-t-4 border-brand-green">
                <h2 class="text-2xl font-bold text-brand-blue mb-6 flex items-center"><span class="w-8 h-8 rounded-full bg-brand-green text-white text-sm flex items-center justify-center mr-3">IV</span> ԿԱՌԱՎԱՐՄԱՆ ՊԼԱՆ</h2>
                
                <div class="space-y-6">
                    <div>
                        <label class="block font-semibold text-gray-700 mb-2">1. Թիմի դերաբաշխում և պարտականություններ</label>
                        <textarea name="roles_plan" rows="3" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-brand-green outline-none"></textarea>
                    </div>
                    <div>
                        <label class="block font-semibold text-gray-700 mb-2">2. Նախնական գործողությունների պլան (ժամանակացույց)</label>
                        <textarea name="action_plan" rows="3" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-brand-green outline-none" placeholder="Օրինակ՝ Նոյեմբեր - թիմի ձևավորում..."></textarea>
                    </div>
                    <div>
                        <label class="block font-semibold text-gray-700 mb-2">3. Անհրաժեշտ աջակցություն / ռեսուրսներ</label>
                        <textarea name="resources" rows="3" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-brand-green outline-none"></textarea>
                    </div>
                </div>
            </section>

             <section class="bg-gray-100 rounded-2xl p-8 border-2 border-dashed border-gray-300">
                <h2 class="text-2xl font-bold text-brand-blue mb-6">V. ՀԱՄԱՁԱՅՆԱԳԻՐ</h2>
                
                <div class="prose max-w-none text-gray-600 mb-6 text-sm">
                    <p class="leading-relaxed">
                        Սույն հայտադիմումով <b><span id="contractSchoolName" class="text-brand-blue font-bold border-b border-gray-400">...</span></b> հաստատությունը
                        հայտնում է իր համաձայնությունը մասնակցելու մրցույթին և իրականացնելու Աշակերտական/Ուսանողական Ընկերության գործունեությունը՝ 
                        համաձայն ծրագրի նպատակների և կազմակերպող կողմի պայմանների։
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-end">
                    <div>
                        <label class="block text-sm text-gray-500 mb-1">Հաստատության ղեկավար (Ա․Ա․Հ․)</label>
                        <input type="text" name="signature_name" class="w-full bg-transparent border-b-2 border-gray-400 px-2 py-1 focus:border-brand-blue outline-none font-bold font-serif" placeholder="Ստորագրողի Անունը">
                    </div>
                    <div class="flex items-center gap-4">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" name="agreement" class="w-6 h-6 text-brand-green rounded focus:ring-brand-green">
                            <span class="ml-3 font-bold text-brand-blue">Հաստատում եմ</span>
                        </label>
                    </div>
                </div>
            </section>

            <div class="flex justify-end pt-6 pb-20">
                <button type="submit" class="bg-gradient-to-r from-brand-blue to-brand-green text-white px-10 py-4 rounded-xl font-bold text-lg shadow-xl hover:shadow-2xl hover:scale-105 transition-all duration-300 flex items-center">
                    <span>Ուղարկել Հայտը</span>
                    <i class="fas fa-paper-plane ml-3"></i>
                </button>
            </div>

        </form>
    </main>
<script>
        const CONFIG = {
            apiUrl: '<?= $base_url ?>/api/apply'
        };
    </script>
    
    <script src="<?= $base_url ?>/assets/js/apply.js?v=2"></script>
</body>
</html>