import { ref, onMounted, onUnmounted, watch, computed } from 'vue';
import { router, useForm, usePage } from '@inertiajs/vue3';
import intus from 'intus';

export const usePolling = (duration) => {
    const interval = ref(null);

    const updateData = () => {
        router.reload({ preserveState: true, preserveScroll: true });
    };
    
    onMounted(() => {
        interval.value = setInterval(() => {
            updateData();
        }, duration);
    });
    
    onUnmounted(() => {
        clearInterval(interval.value);
    });
}

export const useValidatedForm = (definition, messages = {}) => {
    let fields = [];
    let rules = [];
    for(let field in definition) {
        fields[field] = definition[field][0];
        rules[field]  = definition[field][1] || [];
    }

    let form = useForm(fields);
     
    return new Proxy(form, {
        get(target, prop) {
            if(prop === 'submit') {
                form.clearErrors();

                let validation = intus.validate(form.data(), rules, messages);

                if(! validation.passes()) {
                    form.setError(validation.errors());
                    return () => {};
                }
            }

            return target[prop];
        }
    })
};

export const useRole = () => {
    const { auth } = usePage().props;

    return {
        isSuperAdmin: () => auth.user.roles.map(role => role.name).includes('SUPER_ADMIN'),
        isAdmin: () => auth.user.roles.map(role => role.name).includes('ADMIN') || auth.user.parent_user_id !== null,
        isUser: () => auth.user.roles.map(role => role.name).includes('USER') || auth.user.parent_user_id !== null,
    }
};

export const getFiltersCount = (form) => {
  return Object.keys(form.data()).filter(key => key != 'search').filter(key => form[key])?.length
};

export const resetFilterForm = (form) => {
  for(const item in form.data()) {
      if(item == 'search') continue;
      form[item] = null;
  }
}

export const useSearch = ({ items, field, valueKey }) => {
    const searchTerm  = ref('');
    const loadedItems = ref([]);

    watch(searchTerm, value => {
        if(value.length > 0) {
            loadedItems.value = items.filter(
                p => p[field].toLowerCase().includes(value.toLowerCase())
            );
        } else {
            loadedItems.value = items;
        }
    }, { immediate: true });

    return [
        searchTerm,
        loadedItems,
        loadedItems.value.map(item => item[valueKey]),
    ];
}

export const useCheckAll = (data) => {
    const selected = ref([]);

    const onSelectRow = (itemId, checked) => {
        if(checked) {
            if(! selected.value.includes(itemId)) {
                selected.value.push(itemId); 
            }
        } else {
            selected.value = selected.value.filter(id => id != itemId);
        }
    };
    
    const checkAll = computed({
        get() {
            return data.length > 0 ? data.length == selected.value.length : false;
        },

        set(value) {
            const checked = [];

            if(value) {
                data.forEach(row => {
                    checked.push(row.id);
                });
            }

            selected.value = checked;
        }
    });

    return {
        selected,
        checkAll,
        onSelectRow,
    };
};

export const printQrcode = ({ id }) => {
    const qrcodeElement = document.getElementById(id);
    const img = qrcodeElement.querySelector('img');
    const printWindow = window.open('', '_blank');
    printWindow.document.open();
    printWindow.document.write(`
      <html>
      <head>
        <style>
          body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
          }
          img {
            max-width: 100%;
            max-height: 100%;
          }
        </style>
      </head>
      <body>
        <img src="${img.src}" alt="${id}">
      </body>  
      </html>
    `);
    printWindow.document.close();
    printWindow.onload = () => {
      printWindow.print();
      printWindow.close();
    };
}

export const notices = {
    value: [
        {label: 'Valider', value: 'VALIDEE'},
        {label: 'Rejeter', value: 'REJETEE'},
    ],
    validate: 'VALIDEE',
    reject: 'REJETEE',
    default: 'VALIDEE',
};