<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Access</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #050505; color: #e0e0e0; }
        .neon-border { box-shadow: 0 0 10px rgba(99, 169, 0, 0.2); transition: 0.3s; }
        .neon-border:focus-within { box-shadow: 0 0 20px rgba(99, 169, 0, 0.6); border-color: #63A900; }
        .loader { border-top-color: #63A900; -webkit-animation: spinner 1.5s linear infinite; animation: spinner 1.5s linear infinite; }
        @keyframes spinner { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
    </style>
</head>
<body class="flex items-center justify-center h-screen bg-black overflow-hidden relative">

    <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#111 1px, transparent 1px); background-size: 30px 30px;"></div>

    <div class="relative z-10 w-full max-w-md p-8 bg-[#0a0a0a] border border-gray-800 rounded-xl shadow-2xl">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-900 border border-gray-700 mb-4">
                <i class="fas fa-user-secret text-2xl text-gray-500"></i> <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
            </div>
            <h2 class="text-2xl font-bold text-white tracking-widest uppercase">Restricted Area</h2>
            <p class="text-xs text-gray-500 mt-2">Authorized Personnel Only</p>
        </div>

        <form id="loginForm" class="space-y-6">
            <div>
                <label class="block text-xs font-mono text-gray-500 mb-1 uppercase">Identity</label>
                <input type="text" id="username" class="w-full bg-[#111] text-white border border-gray-700 rounded p-3 outline-none neon-border focus:border-green-600 transition-colors" autocomplete="off">
            </div>
            
            <div>
                <label class="block text-xs font-mono text-gray-500 mb-1 uppercase">Access Key</label>
                <input type="password" id="password" class="w-full bg-[#111] text-white border border-gray-700 rounded p-3 outline-none neon-border focus:border-green-600 transition-colors">
            </div>

            <button type="submit" class="w-full py-3 bg-[#63A900] hover:bg-[#4d8500] text-white font-bold rounded shadow-[0_0_15px_rgba(99,169,0,0.5)] transition-all duration-300 transform hover:scale-[1.02] flex justify-center items-center gap-2">
                <span id="btnText">AUTHENTICATE</span>
                <div id="loader" class="loader ease-linear rounded-full border-2 border-t-2 border-gray-200 h-4 w-4 hidden"></div>
            </button>
        </form>

        <div id="errorMsg" class="mt-4 text-center text-red-500 text-sm font-mono opacity-0 transition-opacity"></div>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const btn = document.querySelector('button');
            const loader = document.getElementById('loader');
            const btnText = document.getElementById('btnText');
            const errorMsg = document.getElementById('errorMsg');

            // UI Loading state
            btn.disabled = true;
            btnText.classList.add('hidden');
            loader.classList.remove('hidden');
            errorMsg.style.opacity = '0';

            const u = document.getElementById('username').value;
            const p = document.getElementById('password').value;

            try {
                // ВАЖНО: Используем правильный путь API
                const response = await fetch('secret-login-api', { 
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ username: u, password: p })
                });

                const result = await response.json();

                if (result.status === 'success') {
                    window.location.href = result.redirect;
                } else {
                    throw new Error(result.message);
                }
            } catch (err) {
                errorMsg.textContent = "ACCESS DENIED: " + err.message;
                errorMsg.style.opacity = '1';
                // Shake effect logic could go here
                btn.disabled = false;
                btnText.classList.remove('hidden');
                loader.classList.add('hidden');
            }
        });
    </script>
</body>
</html>