import Alpine from 'alpinejs';

document.addEventListener('alpine:init', () => {
    Alpine.data('jobQuestionsBuilder', (initial = []) => ({
        questions: initial.length ? initial : [],

        addQuestion() {
            if (this.questions.length >= 10) {
                return;
            }

            this.questions.push({
                id: null,
                question: '',
                type: 'text',
                is_required: true,
            });
        },

        removeQuestion(index) {
            this.questions.splice(index, 1);
        },
    }));
});
