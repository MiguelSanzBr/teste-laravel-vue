import { Directive } from 'vue';

export const cnpjMask: Directive<HTMLInputElement> = {
    mounted(el) {
        let isFormatting = false;
        
        el.addEventListener('input', (event) => {
            if (isFormatting) return;
            
            isFormatting = true;
            formatCNPJ(event);
            isFormatting = false;
        });
    },
    beforeUnmount(el) {
        el.removeEventListener('input', formatCNPJ);
    }
};

function formatCNPJ(event: Event) {
    const input = event.target as HTMLInputElement;
    const cursorPosition = input.selectionStart;
    let value = input.value.replace(/\D/g, '');
    
    // Limita a 14 caracteres (tamanho do CNPJ)
    if (value.length > 14) {
        value = value.substring(0, 14);
    }
    
    const originalValue = input.value;
    let formattedValue = value;
    
    if (value.length <= 2) {
        formattedValue = value;
    } else if (value.length <= 5) {
        formattedValue = value.replace(/(\d{2})(\d{0,3})/, '$1.$2');
    } else if (value.length <= 8) {
        formattedValue = value.replace(/(\d{2})(\d{3})(\d{0,3})/, '$1.$2.$3');
    } else if (value.length <= 12) {
        formattedValue = value.replace(/(\d{2})(\d{3})(\d{3})(\d{0,4})/, '$1.$2.$3/$4');
    } else {
        formattedValue = value.replace(/(\d{2})(\d{3})(\d{3})(\d{4})(\d{0,2})/, '$1.$2.$3/$4-$5');
    }
    
    // Só atualiza se o valor mudou
    if (originalValue !== formattedValue) {
        input.value = formattedValue;
        
        // Dispara evento input apenas se o valor realmente mudou
        input.dispatchEvent(new Event('input'));
    }
    
    // Mantém a posição do cursor
    if (cursorPosition !== null) {
        const newCursorPosition = adjustCursorPosition(cursorPosition, originalValue, formattedValue);
        input.setSelectionRange(newCursorPosition, newCursorPosition);
    }
}

function adjustCursorPosition(oldPosition: number, oldValue: string, newValue: string): number {
    // Se adicionou caracteres, avança o cursor
    if (newValue.length > oldValue.length) {
        const diff = newValue.length - oldValue.length;
        return Math.min(oldPosition + diff, newValue.length);
    }
    // Se removeu caracteres, mantém ou recua
    return Math.max(0, Math.min(oldPosition, newValue.length));
}