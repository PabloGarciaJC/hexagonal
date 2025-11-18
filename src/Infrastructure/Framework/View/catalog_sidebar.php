<aside class="catalog-sidebar">
    <form method="GET" action="/?shop=catalog" class="filter-form">
        <h3>Filtrar</h3>

        <div class="filter-group">
            <label for="cat">Categoría:</label>
            <select name="cat" id="cat">
                <option value="">Todas</option>
                <option value="electronica">Electrónica</option>
                <option value="libros">Libros</option>
                <option value="hogar">Hogar</option>
                <option value="moda">Moda</option>
                <option value="deportes">Deportes</option>
            </select>
        </div>

        <div class="filter-group">
            <label>Precio:</label>
            <div class="price-range">
                <input type="number" name="min" placeholder="Mín">
                <span>-</span>
                <input type="number" name="max" placeholder="Máx">
            </div>
        </div>

        <div class="filter-group">
            <label for="order">Ordenar por:</label>
            <select name="order" id="order">
                <option value="">Relevancia</option>
                <option value="price_asc">Precio menor</option>
                <option value="price_desc">Precio mayor</option>
                <option value="name_asc">Nombre A-Z</option>
                <option value="name_desc">Nombre Z-A</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Filtrar</button>
    </form>
</aside>
