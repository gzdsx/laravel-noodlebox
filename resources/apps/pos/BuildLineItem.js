function buildProductAttributes(p) {
    const meta = p.meta_data.filter(m => m.key === 'tm_meta')[0];
    if (!meta) return [];

    const builder = meta.value.tmfbuilder;
    if (!builder) return [];

    //console.log(builder);

    let attributes = {};
    builder.element_type.map(t => {
        if (t === 'selectbox' || t === 'radiobuttons' || t === 'checkboxes') {
            if (Array.isArray(attributes[t])) {
                attributes[t].push({});
            } else {
                attributes[t] = [{}];
            }
        }
    });

    for (let t in attributes) {
        if (t === 'selectbox') {
            attributes[t].forEach((a, i) => {
                a.type = 'single';
                a.name = builder.selectbox_header_title[i];
                a.value = Number(builder.multiple_selectbox_options_default_value[i]);
                a.options = [];

                builder.multiple_selectbox_options_title[i].map((t, j) => {
                    a.options.push({
                        title: t,
                        value: builder.multiple_selectbox_options_value[i][j],
                        price: builder.multiple_selectbox_options_price[i][j]
                    });
                });

                Object.defineProperty(a, 'optionValue', {
                    get() {
                        return this.options[this.value];
                    }
                });
            });
        }

        if (t === 'radiobuttons') {
            attributes[t].forEach((a, i) => {
                a.type = 'single';
                a.name = builder.radiobuttons_header_title[i];
                a.value = Number(builder.multiple_radiobuttons_options_default_value[i]);
                a.options = [];

                builder.multiple_radiobuttons_options_title[i].map((t, j) => {
                    a.options.push({
                        title: t,
                        value: builder.multiple_radiobuttons_options_value[i][j],
                        price: builder.multiple_radiobuttons_options_price[i][j]
                    })
                })

                Object.defineProperty(a, 'optionValue', {
                    get() {
                        return this.options[this.value];
                    }
                });
            });
        }

        if (t === 'checkboxes') {
            attributes[t].forEach((a, i) => {
                a.type = 'multiple';
                a.name = 'With';
                a.value = builder.multiple_checkboxes_options_default_value[i].map(v => v !== '');
                a.options = [];

                builder.multiple_checkboxes_options_title[i].map((t, j) => {
                    a.options.push({
                        title: t,
                        value: builder.multiple_checkboxes_options_value[i][j],
                        price: builder.multiple_checkboxes_options_price[i][j]
                    })
                })

                Object.defineProperty(a, 'optionValue', {
                    get() {
                        return this.options.filter((o, i) => this.value[i]);
                    }
                });
            });
        }
    }

    let attrList = [];
    for (let t in attributes) {
        if (t !== 'checkboxes') {
            attrList = attrList.concat(attributes[t]);
        }
    }

    if (attributes['checkboxes']) {
        attrList = attrList.concat(attributes['checkboxes']);
    }

    return attrList;
}

export default function (p) {
    const item = {
        product_id: p.id,
        name: p.name,
        image: p.images[0] || {},
        quantity: 1,
        regular_price: p.price || 0,
        variation_id: 0,
        attributes: buildProductAttributes(p),
        comments: []
    }

    Object.defineProperty(item, 'price', {
        get() {
            let price = /\d+/.test(this.regular_price) ? Number(p.regular_price) : 0;
            price = this.attributes.reduce((a, b) => {
                if (b.type === 'multiple') {
                    let v = b.optionValue.reduce((c, o) => {
                        if (/\d+/.test(o.price)) {
                            return c + parseFloat(o.price);
                        }
                        return c;
                    }, 0)
                    return a + v;
                } else {
                    let v = /\d+/.test(b.optionValue.price) ? Number(b.optionValue.price) : 0;
                    return a + v;
                }
            }, price);

            return this.comments.reduce((a, b) => a + Number(b.price), price);
        },
        set(v) {

        }
    });

    Object.defineProperty(item, 'subtotal', {
        get() {
            if (!/\d+/.test(this.quantity)) {
                return 0;
            }
            return parseFloat(this.price) * parseInt(this.quantity);
        }
    });

    Object.defineProperty(item, 'total', {
        get() {
            if (!/\d+/.test(this.quantity)) {
                return 0;
            }
            return parseFloat(this.price) * parseInt(this.quantity);
        },
        set(v) {

        }
    });

    Object.defineProperty(item, 'meta_data', {
        get() {
            const attr_metas = this.attributes.map(a => {
                let price = Number(a.optionValue.price) === 0 ? '' : '€' + a.optionValue.price;
                return {
                    key: a.name,
                    value: a.optionValue.title + ' ' + price,
                    display_key: a.name,
                    display_value: a.optionValue.title
                }
            });

            const comment_metas = this.comments.map(c => {
                let price = Number(c.price) === 0 ? '' : '€' + c.price;
                let key = c.type + '-' + c.name;
                let value = c.type + '-' + c.name;
                return {
                    key,
                    value,
                    display_key: key,
                    display_value: value
                }
            });

            return attr_metas.concat(comment_metas);
        }
    });

    Object.defineProperty(item, 'variation_name', {
        get() {
            return this.attributes.map(a => {
                if (a.type === 'multiple') {
                    return a.optionValue.map(v => v.title);
                } else {
                    return a.optionValue.title;
                }
            }).join(', ');
        }
    });

    return item;
}