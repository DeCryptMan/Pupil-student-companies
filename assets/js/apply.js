/**
 * StudentBiz Application Form Handler
 * Senior++ Implementation (Version 2.0 - Cache Busted)
 */

document.addEventListener('DOMContentLoaded', () => {
    
    class ApplicationForm {
        constructor() {
            this.form = document.getElementById('applicationForm');
            // Если формы нет, выходим, чтобы не было ошибок
            if (!this.form) return;

            this.teamTable = document.getElementById('teamRows');
            this.addMemberBtn = document.getElementById('addMemberBtn');
            this.wordCountEl = document.getElementById('wordCount');
            this.ideaDesc = document.getElementById('ideaDesc');
            this.directionSelect = document.getElementById('directionSelect');
            this.schoolNameInput = document.querySelector('input[name="school_name"]');
            
            this.teamCount = 0;
            this.init();
        }

        init() {
            this.addTeamRow();

            if (this.addMemberBtn) {
                this.addMemberBtn.addEventListener('click', () => this.addTeamRow());
            }

            if (this.ideaDesc) {
                this.ideaDesc.addEventListener('input', () => this.checkWordCount());
            }

            if (this.directionSelect) {
                this.directionSelect.addEventListener('change', (e) => this.toggleOtherDirection(e));
            }

            if (this.schoolNameInput) {
                this.schoolNameInput.addEventListener('input', (e) => {
                    const el = document.getElementById('contractSchoolName');
                    if(el) el.textContent = e.target.value || '...';
                });
            }

            this.form.addEventListener('submit', (e) => this.handleSubmit(e));
        }

        addTeamRow() {
            this.teamCount++;
            const counter = document.getElementById('team_count');
            if(counter) counter.value = this.teamCount;

            const row = document.createElement('tr');
            row.className = 'hover:bg-gray-50 transition';
            row.id = `member_${this.teamCount}`;
            
            row.innerHTML = `
                <td class="p-3 border-b text-gray-500 font-bold text-center">${this.teamCount}</td>
                <td class="p-3 border-b"><input type="text" name="team_name_${this.teamCount}" placeholder="Անուն Ազգանուն" class="w-full bg-transparent outline-none border-b border-dashed border-gray-300 focus:border-brand-blue py-1"></td>
                <td class="p-3 border-b"><input type="text" name="team_class_${this.teamCount}" placeholder="Օր. 10ա" class="w-full bg-transparent outline-none border-b border-dashed border-gray-300 focus:border-brand-blue py-1"></td>
                <td class="p-3 border-b"><input type="text" name="team_role_${this.teamCount}" placeholder="Օր. Տնօրեն" class="w-full bg-transparent outline-none border-b border-dashed border-gray-300 focus:border-brand-blue py-1"></td>
                <td class="p-3 border-b text-center">
                    ${this.teamCount > 1 ? `<button type="button" class="text-red-400 hover:text-red-600 remove-row-btn"><i class="fas fa-trash"></i></button>` : ''}
                </td>
            `;
            
            if (this.teamTable) {
                this.teamTable.appendChild(row);
                // Навешиваем событие удаления безопасно
                const btn = row.querySelector('.remove-row-btn');
                if (btn) {
                    btn.addEventListener('click', () => row.remove());
                }
            }
        }

        checkWordCount() {
            if (!this.wordCountEl || !this.ideaDesc) return;

            const text = this.ideaDesc.value.trim();
            const words = text ? text.split(/\s+/).length : 0;
            
            this.wordCountEl.textContent = `${words} / 200 բառ`;
            
            if (words > 200) {
                this.wordCountEl.classList.add('text-red-600', 'font-bold');
                this.wordCountEl.classList.remove('text-gray-400');
            } else {
                this.wordCountEl.classList.remove('text-red-600', 'font-bold');
                this.wordCountEl.classList.add('text-gray-400');
            }
        }

        toggleOtherDirection(e) {
            // ЗАЩИТА ОТ ОШИБКИ NULL
            const otherInput = document.getElementById('directionOther');
            if (!otherInput) return; // Если элемента нет, просто выходим

            if (e.target.value === 'other') {
                otherInput.classList.remove('hidden');
                otherInput.focus();
            } else {
                otherInput.classList.add('hidden');
            }
        }

        async handleSubmit(e) {
            e.preventDefault();
            const btn = this.form.querySelector('button[type="submit"]');
            const originalContent = btn.innerHTML;

            const formData = new FormData(this.form);
            const data = {};
            formData.forEach((value, key) => data[key] = value);

            // Payload для API
            const payload = {
                name: data.mentor_name,
                email: data.mentor_email,
                college: data.school_name,
                idea: data.idea_desc,
                full_data: JSON.stringify(data)
            };

            if (!payload.name || !payload.email || !payload.college) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Ուշադրություն',
                    text: 'Լրացրեք պարտադիր դաշտերը (Դպրոց, Մենթոր)',
                    confirmButtonColor: '#253894'
                });
                return;
            }

            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

            try {
                // Используем CONFIG.apiUrl или фолбек, если он не определен
                const url = (typeof CONFIG !== 'undefined' && CONFIG.apiUrl) ? CONFIG.apiUrl : 'api/apply';
                
                const response = await fetch(url, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(payload)
                });

                const result = await response.json();

                if (result.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Հայտը ուղարկված է!',
                        confirmButtonColor: '#63A900'
                    }).then(() => window.location.href = './');
                } else {
                    throw new Error(result.message);
                }
            } catch (error) {
                Swal.fire({icon: 'error', title: 'Սխալ', text: error.message});
            } finally {
                btn.disabled = false;
                btn.innerHTML = originalContent;
            }
        }
    }

    new ApplicationForm();
});