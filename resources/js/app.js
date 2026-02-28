import './bootstrap';

document.addEventListener('alpine:init', () => {
    Alpine.data('confirmModal', () => ({
        show: false,
        title: 'Confirmar Exclusão',
        message: 'Tem certeza que deseja excluir?',
        onConfirm: null,

        open(title, message, onConfirm) {
            this.title = title;
            this.message = message;
            this.onConfirm = onConfirm;
            this.show = true;
        },

        confirm() {
            if (this.onConfirm) {
                this.onConfirm();
            }
            this.close();
        },

        close() {
            this.show = false;
            this.title = 'Confirmar Exclusão';
            this.message = 'Tem certeza que deseja excluir?';
            this.onConfirm = null;
        }
    }));
});

function confirmDelete(title, message, onConfirm) {
    const event = new CustomEvent('open-confirm-modal', {
        detail: { title, message, onConfirm }
    });
    document.dispatchEvent(event);
}
