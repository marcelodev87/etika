<aside class="main-sidebar dark-bg">
    <section class="sidebar">
        <div class="user-panel black-bg">
            <div class="pull-left image">
                <img
                    src="{!! getAvatar(auth()->user()->id)!!}"
                    class="img-circle appUserAvatar" alt="User Image">
            </div>
            <div class="pull-left info">
                <p class="appUserName">{{auth()->user()->name}}</p>
            </div>
        </div>

        {{-- Sidebar Menu --}}
        <ul class="sidebar-menu tree" data-widget="tree">
            <li class="header dark-bg">Menu</li>

            <li>
                <a href="{!! route('app.index') !!}">
                    <i class="fa fa-tachometer-alt"></i> <span>Painel</span>
                </a>
            </li>

            @if (auth()->user()->hasAnyRole(['adm']))
                <li>
                    <a href="{!! route('app.users.index') !!}">
                        <i class="fa fa-user-secret"></i> <span>Usuários</span>
                    </a>
                </li>
            @endif

            <li>
                <a href="{!! route('app.clients.index') !!}">
                    <i class="fa fa-users"></i> <span>Clientes</span>
                </a>
            </li>

            <li>
                <a href="{!! route('app.processes.index') !!}">
                    <i class="fa fa-clipboard-check"></i> <span>Processos</span>
                </a>
            </li>

            <li>
                <a href="{!! route('app.tasks.index') !!}">
                    <i class="fa fa-check-circle"></i> <span>Tarefas</span>
                </a>
            </li>
        </ul>

    </section>
</aside>
