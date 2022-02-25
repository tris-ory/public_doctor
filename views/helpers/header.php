<header id="topMenu">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <?php foreach ($nav_items as $label_item => $item): ?>
                        <li class="nav-item">
                            <?php if ($label_item == 'Index'): ?>
                                <a class="nav-link<?= $label_item == $actif ? ' active' : '' ?> href="/index.php">Index</a>
                            <?php else: ?>
                                <a class="nav-link<?= $label_item == $actif ? ' active' : '' ?> dropdown-toggle"
                                   href="#" id="dropdown_<?= $item ?>" role="button"
                                   data-bs-toggle="dropdown" aria-expanded="false"><?= $label_item ?></a>
                                <ul class="dropdown-menu" aria-labelledby="dropdown_<?= $item ?>">

                                    <?php foreach ($nav_functions as $label_function => $function): ?>
                                        <li><a class="dropdown-item"
                                               href="/views/<?= $item ?>_<?= $function ?>.php"><?= $label_function ?></a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </nav>
</header>
<main class="bg-secondary bg-gradient">