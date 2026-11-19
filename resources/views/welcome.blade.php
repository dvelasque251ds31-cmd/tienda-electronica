<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio - Tienda Electrónica</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 text-slate-800 min-h-screen flex flex-col">

    <!-- NAVBAR SUPERIOR -->
    <header class="bg-slate-900 text-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="bg-indigo-600 p-2 rounded-lg font-bold text-lg tracking-wider">TE</div>
                <div>
                    <h1 class="font-bold text-lg leading-tight">Tienda Electrónica</h1>
                    <p class="text-xs text-slate-400">Sistema de Inventario y Ventas • API REST</p>
                </div>
            </div>

            <div id="userBar" class="hidden items-center gap-4">
                <span id="userNameDisplay" class="text-sm text-slate-300 font-medium"></span>
                <button onclick="logout()" class="bg-rose-600 hover:bg-rose-700 text-white text-xs font-semibold px-3 py-1.5 rounded-lg transition">
                    Cerrar sesión
                </button>
            </div>
        </div>
    </header>

    <!-- PANTALLA DE LOGIN -->
    <main id="loginSection" class="flex-1 flex items-center justify-center p-4">
        <div class="bg-white w-full max-w-md rounded-2xl shadow-lg p-8 border border-slate-200">
            <div class="text-center mb-6">
                <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-indigo-100 text-indigo-600 font-bold text-xl mb-3">
                    ⚡
                </div>
                <h2 class="text-2xl font-bold text-slate-900">Acceso al Sistema</h2>
                <p class="text-sm text-slate-500 mt-1">Inicia sesión para gestionar inventario y ventas</p>
            </div>

            <div id="loginError" class="hidden mb-4 p-3 rounded-lg bg-rose-50 border border-rose-200 text-rose-700 text-sm"></div>

            <form onsubmit="handleLogin(event)" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Correo electrónico</label>
                    <input type="text" id="loginEmail" value="admin" required
                        class="w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Contraseña</label>
                    <input type="password" id="loginPassword" value="password" required
                        class="w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <button type="submit" id="btnLogin"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 rounded-lg shadow transition">
                    Ingresar al Panel
                </button>
            </form>
        </div>
    </main>

    <!-- PANEL PRINCIPAL (DASHBOARD) -->
    <main id="dashboardSection" class="hidden flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-6 space-y-6">

        <!-- TARJETAS RESUMEN KPI -->
        <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-200">
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Productos en Catálogo</p>
                <p id="kpiProducts" class="text-3xl font-bold text-slate-900 mt-1">0</p>
                <p class="text-xs text-slate-500 mt-1">Equipos, repuestos y accesorios</p>
            </div>
            <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-200">
                <p class="text-xs font-semibold uppercase tracking-wider text-amber-500">Alertas Stock Bajo</p>
                <p id="kpiLowStock" class="text-3xl font-bold text-amber-600 mt-1">0</p>
                <p class="text-xs text-slate-500 mt-1">Requieren reposición inmediata</p>
            </div>
            <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-200">
                <p class="text-xs font-semibold uppercase tracking-wider text-indigo-500">Ventas Completadas</p>
                <p id="kpiSalesCount" class="text-3xl font-bold text-indigo-600 mt-1">0</p>
                <p class="text-xs text-slate-500 mt-1">Comprobantes emitidos</p>
            </div>
            <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-200">
                <p class="text-xs font-semibold uppercase tracking-wider text-emerald-500">Ingresos Totales</p>
                <p id="kpiRevenue" class="text-3xl font-bold text-emerald-600 mt-1">S/ 0.00</p>
                <p class="text-xs text-slate-500 mt-1">Incluye IGV (18%)</p>
            </div>
        </section>

        <!-- PESTAÑAS DE NAVEGACIÓN -->
        <div class="border-b border-slate-200 flex gap-2 overflow-x-auto">
            <button onclick="switchTab('productos')" id="tab-productos"
                class="tab-btn px-4 py-2.5 text-sm font-semibold border-b-2 border-indigo-600 text-indigo-600">
                📦 Inventario y Productos
            </button>
            <button onclick="switchTab('pos')" id="tab-pos"
                class="tab-btn px-4 py-2.5 text-sm font-semibold border-b-2 border-transparent text-slate-500 hover:text-slate-700">
                🛒 Nueva Venta (POS)
            </button>
            <button onclick="switchTab('ventas')" id="tab-ventas"
                class="tab-btn px-4 py-2.5 text-sm font-semibold border-b-2 border-transparent text-slate-500 hover:text-slate-700">
                🧾 Historial de Ventas
            </button>
            <button onclick="switchTab('catalogos')" id="tab-catalogos"
                class="tab-btn px-4 py-2.5 text-sm font-semibold border-b-2 border-transparent text-slate-500 hover:text-slate-700">
                🏷️ Categorías y Marcas
            </button>
        </div>

        <!-- TAB 1: INVENTARIO Y PRODUCTOS -->
        <section id="view-productos" class="space-y-4">
            <div class="bg-white p-4 rounded-xl shadow-sm border border-slate-200 flex flex-col sm:flex-row gap-3 justify-between items-center">
                <div class="flex flex-wrap gap-3 w-full sm:w-auto items-center">
                    <input type="text" id="searchProduct" onkeyup="loadProducts()" placeholder="Buscar por nombre, SKU o modelo..."
                        class="rounded-lg border border-slate-300 px-3.5 py-2 text-sm w-full sm:w-72 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <label class="inline-flex items-center gap-2 text-sm text-slate-700 cursor-pointer">
                        <input type="checkbox" id="filterLowStock" onchange="loadProducts()" class="rounded text-indigo-600">
                        Solo stock bajo
                    </label>
                </div>
                <button onclick="toggleModal('modalProduct', true)"
                    class="w-full sm:w-auto bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-4 py-2 rounded-lg shadow transition">
                    + Nuevo Producto
                </button>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-xs uppercase text-slate-500">
                            <th class="py-3 px-4">SKU</th>
                            <th class="py-3 px-4">Producto / Modelo</th>
                            <th class="py-3 px-4">Categoría / Marca</th>
                            <th class="py-3 px-4 text-right">P. Compra</th>
                            <th class="py-3 px-4 text-right">P. Venta</th>
                            <th class="py-3 px-4 text-center">Stock</th>
                            <th class="py-3 px-4 text-center">Estado</th>
                        </tr>
                    </thead>
                    <tbody id="productsTableBody" class="divide-y divide-slate-200 text-sm"></tbody>
                </table>
            </div>
        </section>

        <!-- TAB 2: NUEVA VENTA (POS) -->
        <section id="view-pos" class="hidden grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow-sm border border-slate-200 space-y-4">
                <h3 class="font-bold text-lg text-slate-900">Agregar Productos a la Venta</h3>
                <div class="flex flex-col sm:flex-row gap-3">
                    <select id="posProductSelect" class="flex-1 rounded-lg border border-slate-300 px-3 py-2 text-sm"></select>
                    <input type="number" id="posQty" value="1" min="1" class="w-24 rounded-lg border border-slate-300 px-3 py-2 text-sm">
                    <button onclick="addToCart()" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-4 py-2 rounded-lg text-sm">
                        Agregar
                    </button>
                </div>

                <div class="overflow-x-auto border rounded-lg">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-slate-50 border-b text-xs uppercase text-slate-500">
                            <tr>
                                <th class="py-2.5 px-3">Producto</th>
                                <th class="py-2.5 px-3 text-right">P. Unit</th>
                                <th class="py-2.5 px-3 text-center">Cant.</th>
                                <th class="py-2.5 px-3 text-right">Subtotal</th>
                                <th class="py-2.5 px-3"></th>
                            </tr>
                        </thead>
                        <tbody id="cartTableBody" class="divide-y"></tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 space-y-4">
                <h3 class="font-bold text-lg text-slate-900">Datos del Comprobante</h3>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Nombre del Cliente *</label>
                    <input type="text" id="saleCustomerName" placeholder="Ej. Juan Pérez"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">DNI / RUC</label>
                    <input type="text" id="saleCustomerDoc" placeholder="Ej. 45891234"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Método de Pago</label>
                    <select id="salePaymentMethod" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                        <option value="efectivo">Efectivo</option>
                        <option value="yape_plin">Yape / Plin</option>
                        <option value="tarjeta">Tarjeta Débito / Crédito</option>
                        <option value="transferencia">Transferencia Bancaria</option>
                    </select>
                </div>

                <div class="border-t pt-4 space-y-1.5 text-sm">
                    <div class="flex justify-between text-slate-600">
                        <span>Subtotal:</span>
                        <span id="posSubtotal">S/ 0.00</span>
                    </div>
                    <div class="flex justify-between text-slate-600">
                        <span>IGV (18%):</span>
                        <span id="posTax">S/ 0.00</span>
                    </div>
                    <div class="flex justify-between font-bold text-lg text-slate-900 pt-1 border-t">
                        <span>Total a Pagar:</span>
                        <span id="posTotal" class="text-emerald-600">S/ 0.00</span>
                    </div>
                </div>

                <button onclick="submitSale()" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 rounded-lg shadow transition">
                    Emitir Comprobante
                </button>
            </div>
        </section>

        <!-- TAB 3: HISTORIAL DE VENTAS -->
        <section id="view-ventas" class="hidden">
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-xs uppercase text-slate-500">
                            <th class="py-3 px-4">Comprobante</th>
                            <th class="py-3 px-4">Cliente</th>
                            <th class="py-3 px-4">Método</th>
                            <th class="py-3 px-4">Items</th>
                            <th class="py-3 px-4 text-right">Total</th>
                            <th class="py-3 px-4 text-center">Estado</th>
                            <th class="py-3 px-4 text-center">Acción</th>
                        </tr>
                    </thead>
                    <tbody id="salesTableBody" class="divide-y divide-slate-200 text-sm"></tbody>
                </table>
            </div>
        </section>

        <!-- TAB 4: CATEGORÍAS Y MARCAS -->
        <section id="view-catalogos" class="hidden grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200 space-y-4">
                <h3 class="font-bold text-base text-slate-900">Categorías</h3>
                <div class="flex gap-2">
                    <input type="text" id="newCatName" placeholder="Nueva categoría..." class="flex-1 rounded-lg border border-slate-300 px-3 py-2 text-sm">
                    <button onclick="createCategory()" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-semibold">Guardar</button>
                </div>
                <ul id="categoriesList" class="divide-y text-sm"></ul>
            </div>

            <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200 space-y-4">
                <h3 class="font-bold text-base text-slate-900">Marcas</h3>
                <div class="flex gap-2">
                    <input type="text" id="newBrandName" placeholder="Nueva marca..." class="flex-1 rounded-lg border border-slate-300 px-3 py-2 text-sm">
                    <button onclick="createBrand()" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-semibold">Guardar</button>
                </div>
                <ul id="brandsList" class="divide-y text-sm"></ul>
            </div>
        </section>
    </main>

    <!-- MODAL NUEVO PRODUCTO -->
    <div id="modalProduct" class="hidden fixed inset-0 bg-slate-900/50 flex items-center justify-center p-4 z-50">
        <div class="bg-white rounded-2xl max-w-lg w-full p-6 space-y-4 shadow-xl">
            <div class="flex justify-between items-center border-b pb-3">
                <h3 class="font-bold text-lg">Registrar Nuevo Producto</h3>
                <button onclick="toggleModal('modalProduct', false)" class="text-slate-400 hover:text-slate-600 font-bold">✕</button>
            </div>
            <form onsubmit="createProduct(event)" class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
                <div>
                    <label class="block text-xs font-semibold mb-1">Categoría *</label>
                    <select id="prodCategory" required class="w-full rounded-lg border border-slate-300 px-3 py-2"></select>
                </div>
                <div>
                    <label class="block text-xs font-semibold mb-1">Marca *</label>
                    <select id="prodBrand" required class="w-full rounded-lg border border-slate-300 px-3 py-2"></select>
                </div>
                <div>
                    <label class="block text-xs font-semibold mb-1">SKU Único *</label>
                    <input type="text" id="prodSku" required placeholder="Ej. LAP-HP-002" class="w-full rounded-lg border border-slate-300 px-3 py-2">
                </div>
                <div>
                    <label class="block text-xs font-semibold mb-1">Modelo</label>
                    <input type="text" id="prodModel" placeholder="Ej. Pavilion 15" class="w-full rounded-lg border border-slate-300 px-3 py-2">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-xs font-semibold mb-1">Nombre del Producto *</label>
                    <input type="text" id="prodName" required placeholder="Ej. Laptop HP Pavilion 15 Ryzen 7" class="w-full rounded-lg border border-slate-300 px-3 py-2">
                </div>
                <div>
                    <label class="block text-xs font-semibold mb-1">Precio Compra (S/) *</label>
                    <input type="number" step="0.01" id="prodPurchase" required class="w-full rounded-lg border border-slate-300 px-3 py-2">
                </div>
                <div>
                    <label class="block text-xs font-semibold mb-1">Precio Venta (S/) *</label>
                    <input type="number" step="0.01" id="prodSale" required class="w-full rounded-lg border border-slate-300 px-3 py-2">
                </div>
                <div>
                    <label class="block text-xs font-semibold mb-1">Stock Inicial *</label>
                    <input type="number" id="prodStock" value="10" required class="w-full rounded-lg border border-slate-300 px-3 py-2">
                </div>
                <div>
                    <label class="block text-xs font-semibold mb-1">Stock Mínimo Alerta *</label>
                    <input type="number" id="prodMinStock" value="5" required class="w-full rounded-lg border border-slate-300 px-3 py-2">
                </div>
                <div class="sm:col-span-2 flex justify-end gap-2 pt-3 border-t">
                    <button type="button" onclick="toggleModal('modalProduct', false)" class="px-4 py-2 rounded-lg border">Cancelar</button>
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg font-semibold">Guardar Producto</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let token = localStorage.getItem('tienda_token') || null;
        let allProducts = [];
        let cart = [];

        function apiHeaders() {
            return {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            };
        }

        async function handleLogin(e) {
            e.preventDefault();
            const errBox = document.getElementById('loginError');
            errBox.classList.add('hidden');
            const email = document.getElementById('loginEmail').value;
            const password = document.getElementById('loginPassword').value;

            const res = await fetch('/api/login', {
                method: 'POST',
                headers: { 'Accept': 'application/json', 'Content-Type': 'application/json' },
                body: JSON.stringify({ email, password })
            });
            const data = await res.json();

            if (!res.ok) {
                errBox.textContent = data.message || 'Error al iniciar sesión.';
                errBox.classList.remove('hidden');
                return;
            }

            token = data.token;
            localStorage.setItem('tienda_token', token);
            localStorage.setItem('tienda_user', data.user.name);
            initApp();
        }

        async function logout() {
            await fetch('/api/logout', { method: 'POST', headers: apiHeaders() });
            localStorage.removeItem('tienda_token');
            localStorage.removeItem('tienda_user');
            token = null;
            document.getElementById('dashboardSection').classList.add('hidden');
            document.getElementById('userBar').classList.add('hidden');
            document.getElementById('loginSection').classList.remove('hidden');
        }

        function switchTab(tab) {
            ['productos', 'pos', 'ventas', 'catalogos'].forEach(t => {
                document.getElementById(`view-${t}`).classList.add('hidden');
                const btn = document.getElementById(`tab-${t}`);
                btn.classList.remove('border-indigo-600', 'text-indigo-600');
                btn.classList.add('border-transparent', 'text-slate-500');
            });
            document.getElementById(`view-${tab}`).classList.remove('hidden');
            const active = document.getElementById(`tab-${tab}`);
            active.classList.add('border-indigo-600', 'text-indigo-600');
            active.classList.remove('border-transparent', 'text-slate-500');
        }

        function toggleModal(id, show) {
            document.getElementById(id).classList.toggle('hidden', !show);
        }

        async function loadCatalogs() {
            const [resCat, resBrand] = await Promise.all([
                fetch('/api/categories', { headers: apiHeaders() }),
                fetch('/api/brands', { headers: apiHeaders() })
            ]);
            const categories = await resCat.json();
            const brands = await resBrand.json();

            document.getElementById('prodCategory').innerHTML = categories.map(c => `<option value="${c.id}">${c.name}</option>`).join('');
            document.getElementById('prodBrand').innerHTML = brands.map(b => `<option value="${b.id}">${b.name}</option>`).join('');

            document.getElementById('categoriesList').innerHTML = categories.map(c =>
                `<li class="py-2 flex justify-between"><span>${c.name}</span><span class="text-xs bg-slate-100 px-2 py-0.5 rounded">${c.products_count} prod.</span></li>`
            ).join('');

            document.getElementById('brandsList').innerHTML = brands.map(b =>
                `<li class="py-2 flex justify-between"><span>${b.name}</span><span class="text-xs bg-slate-100 px-2 py-0.5 rounded">${b.products_count} prod.</span></li>`
            ).join('');
        }

        async function loadProducts() {
            const search = document.getElementById('searchProduct').value;
            const lowStock = document.getElementById('filterLowStock').checked ? 1 : '';
            const params = new URLSearchParams();
            if (search) params.append('search', search);
            if (lowStock) params.append('low_stock', 1);

            const res = await fetch(`/api/products?${params.toString()}`, { headers: apiHeaders() });
            if (res.status === 401) return logout();
            const paginated = await res.json();
            const products = paginated.data || [];

            if (!search && !lowStock) {
                allProducts = products;
                document.getElementById('kpiProducts').textContent = paginated.total;
                const lowCount = products.filter(p => p.stock <= p.min_stock).length;
                document.getElementById('kpiLowStock').textContent = lowCount;
                document.getElementById('posProductSelect').innerHTML = products.map(p =>
                    `<option value="${p.id}">[${p.sku}] ${p.name} — S/ ${p.sale_price} (Stock: ${p.stock})</option>`
                ).join('');
            }

            document.getElementById('productsTableBody').innerHTML = products.map(p => {
                const isLow = p.stock <= p.min_stock;
                return `
                    <tr class="hover:bg-slate-50">
                        <td class="py-3 px-4 font-mono text-xs font-semibold text-indigo-600">${p.sku}</td>
                        <td class="py-3 px-4">
                            <div class="font-medium text-slate-900">${p.name}</div>
                            <div class="text-xs text-slate-400">${p.model || '-'}</div>
                        </td>
                        <td class="py-3 px-4 text-xs text-slate-600">${p.category?.name || ''} • <b>${p.brand?.name || ''}</b></td>
                        <td class="py-3 px-4 text-right text-slate-500">S/ ${p.purchase_price}</td>
                        <td class="py-3 px-4 text-right font-semibold text-slate-900">S/ ${p.sale_price}</td>
                        <td class="py-3 px-4 text-center font-bold ${isLow ? 'text-rose-600' : 'text-slate-800'}">${p.stock}</td>
                        <td class="py-3 px-4 text-center">
                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold ${isLow ? 'bg-amber-100 text-amber-800' : 'bg-emerald-100 text-emerald-800'}">
                                ${isLow ? 'Stock Bajo' : 'Disponible'}
                            </span>
                        </td>
                    </tr>
                `;
            }).join('');
        }

        async function createProduct(e) {
            e.preventDefault();
            const payload = {
                category_id: document.getElementById('prodCategory').value,
                brand_id: document.getElementById('prodBrand').value,
                sku: document.getElementById('prodSku').value,
                model: document.getElementById('prodModel').value,
                name: document.getElementById('prodName').value,
                purchase_price: document.getElementById('prodPurchase').value,
                sale_price: document.getElementById('prodSale').value,
                stock: document.getElementById('prodStock').value,
                min_stock: document.getElementById('prodMinStock').value,
            };
            const res = await fetch('/api/products', {
                method: 'POST',
                headers: apiHeaders(),
                body: JSON.stringify(payload)
            });
            const data = await res.json();
            if (!res.ok) return alert(data.message || 'Error al guardar producto');
            toggleModal('modalProduct', false);
            e.target.reset();
            loadProducts();
            loadCatalogs();
        }

        function addToCart() {
            const prodId = parseInt(document.getElementById('posProductSelect').value);
            const qty = parseInt(document.getElementById('posQty').value);
            const prod = allProducts.find(p => p.id === prodId);
            if (!prod || qty < 1) return;
            if (qty > prod.stock) return alert(`Stock insuficiente. Disponible: ${prod.stock}`);

            const existing = cart.find(item => item.product_id === prodId);
            if (existing) {
                if (existing.quantity + qty > prod.stock) return alert('Supera el stock disponible.');
                existing.quantity += qty;
            } else {
                cart.push({ product_id: prod.id, name: prod.name, price: parseFloat(prod.sale_price), quantity: qty });
            }
            renderCart();
        }

        function removeFromCart(index) {
            cart.splice(index, 1);
            renderCart();
        }

        function renderCart() {
            let subtotal = 0;
            document.getElementById('cartTableBody').innerHTML = cart.map((item, idx) => {
                const sub = item.price * item.quantity;
                subtotal += sub;
                return `
                    <tr>
                        <td class="py-2 px-3 font-medium">${item.name}</td>
                        <td class="py-2 px-3 text-right">S/ ${item.price.toFixed(2)}</td>
                        <td class="py-2 px-3 text-center">${item.quantity}</td>
                        <td class="py-2 px-3 text-right font-semibold">S/ ${sub.toFixed(2)}</td>
                        <td class="py-2 px-3 text-right"><button onclick="removeFromCart(${idx})" class="text-rose-600 font-bold">✕</button></td>
                    </tr>
                `;
            }).join('');

            const tax = subtotal * 0.18;
            const total = subtotal + tax;
            document.getElementById('posSubtotal').textContent = `S/ ${subtotal.toFixed(2)}`;
            document.getElementById('posTax').textContent = `S/ ${tax.toFixed(2)}`;
            document.getElementById('posTotal').textContent = `S/ ${total.toFixed(2)}`;
        }

        async function submitSale() {
            const customer_name = document.getElementById('saleCustomerName').value.trim();
            if (!customer_name) return alert('Ingresa el nombre del cliente.');
            if (cart.length === 0) return alert('Agrega al menos un producto al carrito.');

            const payload = {
                customer_name,
                customer_document: document.getElementById('saleCustomerDoc').value.trim(),
                payment_method: document.getElementById('salePaymentMethod').value,
                items: cart.map(c => ({ product_id: c.product_id, quantity: c.quantity }))
            };

            const res = await fetch('/api/sales', {
                method: 'POST',
                headers: apiHeaders(),
                body: JSON.stringify(payload)
            });
            const data = await res.json();
            if (!res.ok) return alert(data.message || 'Error al registrar venta');

            alert(`¡Venta registrada! Comprobante: ${data.data.invoice_number}`);
            cart = [];
            renderCart();
            document.getElementById('saleCustomerName').value = '';
            document.getElementById('saleCustomerDoc').value = '';
            await loadProducts();
            await loadSales();
            switchTab('ventas');
        }

        async function loadSales() {
            const res = await fetch('/api/sales', { headers: apiHeaders() });
            const paginated = await res.json();
            const sales = paginated.data || [];

            const completed = sales.filter(s => s.status === 'completada');
            document.getElementById('kpiSalesCount').textContent = completed.length;
            const totalRev = completed.reduce((acc, s) => acc + parseFloat(s.total), 0);
            document.getElementById('kpiRevenue').textContent = `S/ ${totalRev.toFixed(2)}`;

            document.getElementById('salesTableBody').innerHTML = sales.map(s => `
                <tr class="hover:bg-slate-50">
                    <td class="py-3 px-4 font-mono font-bold text-indigo-600">${s.invoice_number}</td>
                    <td class="py-3 px-4">
                        <div class="font-medium">${s.customer_name}</div>
                        <div class="text-xs text-slate-400">${s.customer_document || 'Sin doc.'}</div>
                    </td>
                    <td class="py-3 px-4 uppercase text-xs">${s.payment_method.replace('_', '/')}</td>
                    <td class="py-3 px-4 text-xs text-slate-600">${s.details.map(d => `${d.quantity}x ${d.product?.name}`).join(', ')}</td>
                    <td class="py-3 px-4 text-right font-bold">S/ ${s.total}</td>
                    <td class="py-3 px-4 text-center">
                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold ${s.status === 'completada' ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800'}">
                            ${s.status}
                        </span>
                    </td>
                    <td class="py-3 px-4 text-center">
                        ${s.status === 'completada' ? `<button onclick="cancelSale(${s.id})" class="text-xs text-rose-600 hover:underline font-semibold">Anular</button>` : '-'}
                    </td>
                </tr>
            `).join('');
        }

        async function cancelSale(id) {
            if (!confirm('¿Seguro que deseas anular esta venta y devolver el stock?')) return;
            const res = await fetch(`/api/sales/${id}`, { method: 'DELETE', headers: apiHeaders() });
            const data = await res.json();
            alert(data.message);
            loadProducts();
            loadSales();
        }

        async function createCategory() {
            const name = document.getElementById('newCatName').value.trim();
            if (!name) return;
            await fetch('/api/categories', { method: 'POST', headers: apiHeaders(), body: JSON.stringify({ name }) });
            document.getElementById('newCatName').value = '';
            loadCatalogs();
        }

        async function createBrand() {
            const name = document.getElementById('newBrandName').value.trim();
            if (!name) return;
            await fetch('/api/brands', { method: 'POST', headers: apiHeaders(), body: JSON.stringify({ name }) });
            document.getElementById('newBrandName').value = '';
            loadCatalogs();
        }

        async function initApp() {
            if (!token) return;
            document.getElementById('loginSection').classList.add('hidden');
            document.getElementById('dashboardSection').classList.remove('hidden');
            document.getElementById('userBar').classList.remove('hidden');
            document.getElementById('userBar').classList.add('flex');
            document.getElementById('userNameDisplay').textContent = `👤 ${localStorage.getItem('tienda_user') || 'Admin'}`;

            await Promise.all([loadCatalogs(), loadProducts(), loadSales()]);
        }

        initApp();
    </script>
</body>
</html>