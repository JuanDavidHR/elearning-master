<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item mr-auto">
                    <a class="navbar-brand">
                        <h2 class="brand-text mb-0">B'Medic</h2>
                    </a>
                </li>
                <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="feather icon-x d-block d-xl-none font-medium-4 success toggle-icon"></i><i class="toggle-icon feather icon-disc font-medium-4 d-none d-xl-block collapse-toggle-icon success" data-ticon="icon-disc"></i></a></li>
            </ul>
        </div>
        <div class="shadow-bottom"></div>
        <div class="main-menu-content">
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                <li class=" navigation-header">
                    <span>Módulos</span>
                </li>
                <li class=" nav-item active" @click="menu=0">
                    <a href="#">
                        <i class="feather icon-bar-chart"></i>
                        <span class="menu-title" data-i18n="Chat">Dashboard</span>
                    </a>
                </li>
                <li class=" nav-item">
                    <a>
                        <i class="feather icon-home"></i>
                        <span class="menu-title" data-i18n="Ecommerce">
                            Laboratorios
                        </span>
                    </a>
                    <ul class="menu-content">
                        <li @click="menu=1000">
                            <a>
                                <i class="feather icon-circle"></i>
                                <span class="menu-item" data-i18n="Shop">
                                    Gestionar Laboratorios
                                </span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class=" nav-item">
                    <a>
                        <i class="feather icon-home"></i>
                        <span class="menu-title" data-i18n="Ecommerce">
                            Medicamentos
                        </span>
                    </a>
                    <ul class="menu-content">
                        <li @click="menu=1001">
                            <a>
                                <i class="feather icon-circle"></i>
                                <span class="menu-item" data-i18n="Shop">
                                    Gestionar Tipo Medicamentos
                                </span>
                            </a>
                        </li>
                    </ul>
                    <ul class="menu-content">
                        <li @click="menu=1002">
                            <a>
                                <i class="feather icon-circle"></i>
                                <span class="menu-item" data-i18n="Shop">
                                    Gestionar Presentacion
                            </a>
                        </li>
                    </ul>
                    <ul class="menu-content">
                        <li @click="menu=1003">
                            <a>
                                <i class="feather icon-circle"></i>
                                <span class="menu-item" data-i18n="Shop">
                                    Gestionar Medicamento
                            </a>
                        </li>
                    </ul>
                </li>
                {{-- <li class=" nav-item">
                    <a>
                        <i class="feather icon-home"></i>
                        <span class="menu-title" data-i18n="Ecommerce">
                            Detalle Presentacion
                        </span>
                    </a>
                    <ul class="menu-content">
                        <li @click="menu=1005">
                            <a>
                                <i class="feather icon-circle"></i>
                                <span class="menu-item" data-i18n="Shop">
                                    Mantenimiento Presentacion
                                </span>
                            </a>
                        </li>
                    </ul>
                </li>
                 --}}
                <li class=" nav-item">
                    <a>
                        <i class="feather icon-home"></i>
                        <span class="menu-title" data-i18n="Ecommerce">
                            Boticas
                        </span>
                    </a>
                    <ul class="menu-content">
                        <li @click="menu=1004">
                            <a>
                                <i class="feather icon-circle"></i>
                                <span class="menu-item" data-i18n="Shop">
                                    Gestionar Boticas
                                </span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class=" nav-item">
                    <a>
                        <i class="feather icon-home"></i>
                        <span class="menu-title" data-i18n="Ecommerce">
                            Detalle Medicamento
                        </span>
                    </a>
                    <ul class="menu-content">
                        <li @click="menu=1006">
                            <a>
                                <i class="feather icon-circle"></i>
                                <span class="menu-item" data-i18n="Shop">
                                    Mantenimiento Medicamento
                                </span>
                            </a>
                        </li>
                    </ul>
                </li>
                
                
            </ul>
        </div>
    </div>

