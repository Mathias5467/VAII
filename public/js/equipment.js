
class EquipmentRow {
    constructor(tr) {
        this.element = tr;
        this.serial = tr.dataset.serial || '';
        this.name = tr.dataset.name || '';
        this.category = tr.dataset.category || '';
        this.box = tr.dataset.box || '';
        this.status = tr.dataset.status || '';
    }

    get(key) {
        return this[key] ?? '';
    }

    matches(filters) {
        const text = filters.search;
        if (text) {
            const haystack = normalize(`${this.serial} ${this.name} ${this.box}`);
            if (!haystack.includes(text)) return false;
        }
        if (filters.category && this.category !== filters.category) return false;
        if (filters.status && this.status !== filters.status) return false;
        if (filters.box && this.box !== filters.box) return false;
        return true;
    }

    setVisible(visible) {
        this.element.style.display = visible ? '' : 'none';
    }
}

class EquipmentTable {
    constructor(table) {
        this.table = table;
        this.tbody = table.querySelector('tbody');
        this.rows = Array.from(this.tbody.querySelectorAll('tr[data-serial]'))
            .map(tr => new EquipmentRow(tr));
        this.sortKey = null;
        this.sortAsc = true;
        this.emptyRow = this.createEmptyRow();
        this.headers = Array.from(table.querySelectorAll('th[data-sort]'));
        this.headers.forEach(th => {
            th.style.cursor = 'pointer';
            th.title = 'Kliknutím zoradíte';
            th.addEventListener('click', () => this.sortBy(th.dataset.sort));
        });
    }

    createEmptyRow() {
        const tr = document.createElement('tr');
        const td = document.createElement('td');
        td.colSpan = this.table.querySelectorAll('thead th').length;
        td.style.textAlign = 'center';
        td.textContent = 'Žiadne zariadenie nevyhovuje filtru.';
        tr.appendChild(td);
        tr.style.display = 'none';
        this.tbody.appendChild(tr);
        return tr;
    }

    uniqueValues(key) {
        const values = new Set(this.rows.map(r => r.get(key)).filter(v => v !== ''));
        return Array.from(values).sort((a, b) => a.localeCompare(b, 'sk'));
    }

    applyFilter(filters) {
        const visible = [];
        this.rows.forEach(row => {
            const ok = row.matches(filters);
            row.setVisible(ok);
            if (ok) visible.push(row);
        });
        const showEmpty = visible.length === 0 && this.rows.length > 0;
        this.emptyRow.style.display = showEmpty ? '' : 'none';
        return visible;
    }

    sortBy(key) {
        this.sortAsc = (this.sortKey === key) ? !this.sortAsc : true;
        this.sortKey = key;
        const dir = this.sortAsc ? 1 : -1;
        this.rows.sort((a, b) =>
            a.get(key).localeCompare(b.get(key), 'sk', { numeric: true }) * dir);
        this.rows.forEach(row => this.tbody.insertBefore(row.element, this.emptyRow));
        this.updateHeaderIcons();
    }

    updateHeaderIcons() {
        this.headers.forEach(th => {
            let icon = th.querySelector('.sort-icon');
            if (!icon) {
                icon = document.createElement('i');
                icon.className = 'sort-icon';
                icon.style.marginLeft = '0.4rem';
                th.appendChild(icon);
            }
            if (th.dataset.sort === this.sortKey) {
                icon.className = 'sort-icon fa-solid ' + (this.sortAsc ? 'fa-sort-up' : 'fa-sort-down');
            } else {
                icon.className = 'sort-icon fa-solid fa-sort';
            }
        });
    }
}


class FilterPanel {
    constructor(container, table, onChange) {
        this.search = container.querySelector('[data-filter="search"]');
        this.category = container.querySelector('[data-filter="category"]');
        this.status = container.querySelector('[data-filter="status"]');
        this.box = container.querySelector('[data-filter="box"]');
        this.resetBtn = container.querySelector('[data-filter="reset"]');
        this.onChange = onChange;

        fillSelect(this.category, table.uniqueValues('category'));
        fillSelect(this.status, table.uniqueValues('status'));
        fillSelect(this.box, table.uniqueValues('box'));

        this.search.addEventListener('input', () => this.onChange(this.values()));
        [this.category, this.status, this.box].forEach(sel =>
            sel.addEventListener('change', () => this.onChange(this.values())));
        this.resetBtn.addEventListener('click', () => this.reset());
        this.search.addEventListener('keydown', e => {
            if (e.key === 'Escape') this.reset();
        });
    }

    values() {
        return {
            search: normalize(this.search.value.trim()),
            category: this.category.value,
            status: this.status.value,
            box: this.box.value,
        };
    }

    reset() {
        this.search.value = '';
        this.category.value = '';
        this.status.value = '';
        this.box.value = '';
        this.onChange(this.values());
        this.search.focus();
    }
}


class StatsPanel {
    constructor(element, total) {
        this.element = element;
        this.total = total;
    }

    render(visibleRows) {
        const counts = {};
        visibleRows.forEach(r => { counts[r.status] = (counts[r.status] || 0) + 1; });

        this.element.textContent = '';
        const summary = document.createElement('strong');
        summary.textContent = `Zobrazené: ${visibleRows.length} / ${this.total}`;
        this.element.appendChild(summary);

        Object.keys(counts).sort((a, b) => a.localeCompare(b, 'sk')).forEach(status => {
            const badge = document.createElement('span');
            badge.className = 'badge ' + badgeClassFor(status);
            badge.style.marginLeft = '0.5rem';
            badge.textContent = `${status}: ${counts[status]}`;
            this.element.appendChild(badge);
        });
    }
}



function normalize(text) {
    return text.toLowerCase().normalize('NFD').replace(/[̀-ͯ]/g, '');
}

function fillSelect(select, values) {
    values.forEach(value => {
        const option = document.createElement('option');
        option.value = value;
        option.textContent = value;
        select.appendChild(option);
    });
}

function badgeClassFor(status) {
    if (status === 'V servise') return 'badge-warning';
    if (status === 'Poškodená') return 'badge-danger';
    return 'badge-success';
}



document.addEventListener('DOMContentLoaded', () => {
    const tableEl = document.getElementById('equipment-table');
    const filtersEl = document.getElementById('equipment-filters');
    const statsEl = document.getElementById('equipment-stats');
    if (!tableEl || !filtersEl || !statsEl) return;

    const table = new EquipmentTable(tableEl);
    const stats = new StatsPanel(statsEl, table.rows.length);
    const refresh = filters => stats.render(table.applyFilter(filters));

    const panel = new FilterPanel(filtersEl, table, refresh);
    table.updateHeaderIcons();
    refresh(panel.values());
});
