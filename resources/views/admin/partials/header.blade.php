<nav class="navbar bg-white shadow-sm px-4">

    <h4>

        Admin Dashboard

    </h4>

    <div class="dropdown">

        <a class="dropdown-toggle text-dark text-decoration-none"
           href="#"
           data-bs-toggle="dropdown">

            {{ auth()->user()->name }}

        </a>

        <ul class="dropdown-menu dropdown-menu-end">

            <li>

                <a class="dropdown-item" href="#">

                    Profile

                </a>

            </li>

            <li>

                <form action="{{ route('logout') }}" method="POST">

                    @csrf

                    <button class="dropdown-item">

                        Logout

                    </button>

                </form>

            </li>

        </ul>

    </div>

</nav>