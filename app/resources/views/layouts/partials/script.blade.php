<script>
    function quoteForm(config) {
        return {
            items: config.items,
            lines: config.lineItems || config.old,
            currencySymbol: config.currencySymbol,
            init() {
                if (this.lines.length === 0) {
                    this.addLine();
                }
            },
            addLine() {
                this.lines.push({ item_id: '', quantity: 1, unit_price: 0 });
            },
            removeLine(index) {
                if (this.lines.length > 1) this.lines.splice(index, 1);
            },
            updateLine(index) {
                let selectedItem = this.items.find(item => item.id == this.lines[index].item_id);
                if (selectedItem) this.lines[index].unit_price = parseFloat(selectedItem.sale_price);
            },
            formatCurrency(amount) {
                if (isNaN(amount)) amount = 0;
                return this.currencySymbol + amount.toFixed(2);
            },
            get subtotal() {
                let sub = this.lines.reduce((acc, line) => acc + ((line.quantity || 0) * (line.unit_price || 0)), 0);
                return isNaN(sub) ? 0 : sub;
            },
            get tax() {
                return this.subtotal * 0; // 0% tax for now
            },
            get total() {
                return this.subtotal + this.tax;
            }
        }
    }
</script>
<script src="//unpkg.com/alpinejs" defer></script>