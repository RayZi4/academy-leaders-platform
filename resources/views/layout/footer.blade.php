<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-3">
                <h5 class="text-white">Академия молодых лидеров</h5>
                <p>Развивай навыки, создавай проекты, находи работу мечты.</p>
            </div>
            <div class="col-md-4 mb-3">
                <h5 class="text-white">Контакты</h5>
                <p><i class="bi bi-geo-alt-fill"></i> г. Нижний Новгород, ул. Варварская, д. 32А</p>
                <p><i class="bi bi-envelope-fill"></i> info@academy-leaders.ru</p>
            </div>
            <div class="col-md-4 mb-3">
                <h5 class="text-white">Полезные ссылки</h5>
                <ul class="list-unstyled">
                    <li><a href="{{ route('catalog') }}">Проекты</a></li>
                    <li><a href="{{ route('leaderboard') }}">Рейтинг студентов</a></li>
                    <li><a href="{{ route('about') }}">О нас</a></li>
                </ul>
            </div>
        </div>

        <!-- Блок соцсетей (все ссылки) -->
        <div class="row mt-3 pt-2 border-top border-secondary">
            <div class="col-12">
                <h6 class="text-white mb-2">Мы в соцсетях</h6>
                <div class="d-flex flex-wrap gap-3 justify-content-start align-items-center">
                    <a href="https://vk.com/ano_mol_lid" target="_blank" rel="noopener noreferrer" class="text-white-50 text-decoration-none small">
                        <i class="bi bi-vk"></i> Академия лидеров
                    </a>
                    <a href="https://vk.com/trud.nobl" target="_blank" rel="noopener noreferrer" class="text-white-50 text-decoration-none small">
                        <i class="bi bi-briefcase"></i> Управление по труду
                    </a>
                    <a href="https://vk.com/minsocium_nn" target="_blank" rel="noopener noreferrer" class="text-white-50 text-decoration-none small">
                        <i class="bi bi-people"></i> Минсоциум НО
                    </a>
                    <a href="https://vk.com/molparlament52" target="_blank" rel="noopener noreferrer" class="text-white-50 text-decoration-none small">
                        <i class="bi bi-graph-up"></i> Молодёжный парламент
                    </a>
                    <a href="https://vk.com/molodoy_parlamentariy" target="_blank" rel="noopener noreferrer" class="text-white-50 text-decoration-none small">
                        <i class="bi bi-chat-dots"></i> Клуб коммуникаций
                    </a>
                </div>
            </div>
        </div>

        <hr class="mt-3 mb-3" style="border-color: #334155;">
        <div class="text-center">
            (c) {{ date('Y') }} Академия молодых лидеров. Все права защищены.
        </div>
    </div>
</footer>
