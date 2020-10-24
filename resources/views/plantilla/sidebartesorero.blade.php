<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-title">
                Opciones
            </li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-bag"></i>Egresos</a>
                <ul class="nav-dropdown-items">
                    <li @click.prevent="menu=1" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-bag"></i>Control de Encargos</a>
                    </li>
                    <li @click.prevent="menu=2" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-bag"></i>Control de Viáticos</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-wallet"></i>Garantías</a>
                <ul class="nav-dropdown-items">
                    <li @click.prevent=" menu = 3" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-wallet"></i>Fiel Cumplimiento</a>
                    </li>
                    <li @click.prevent="menu=4" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-notebook"></i>Adelanto Directo</a>
                    </li>
                    <li @click.prevent="menu=5" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-notebook"></i>Adelanto Materiales</a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>