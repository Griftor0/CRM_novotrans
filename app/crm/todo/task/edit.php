<?php
$title = 'Edit Task';
ob_start();
?>
<style>
    .b {
    background-color: #007BFB;
    text-decoration: none;
    color: #fff;
    border:none;
    border-radius: 8px;
    padding: 8px 25px;
    transition: opacity 0.3s;
    margin-top: 10px;
    }
    .b:hover {
        color:#fff;
        opacity: 0.7;
    }
</style>
<div class="container d-flex flex-column justify-content-center align-items-center">
    <h1 class="my-4">Редактировать заявку</h1>
    <form action="/crm/todo/tasks/updateTask" method="POST">
        <div style="background: #ededee; padding: 30px; width: 500px; border-radius: 20px; border: 2px solid rgba(255, 255, 255, 0.5) ">
            <input type="hidden" name="id" value="<?= $selectedTask['id'] ?>">
            <div class="row">
                <!-- Category field -->
                <div class="col-12 col-md-6 mb-3">
                    <label for="category_id">Тип страхования</label>
                    <select class="form-control" id="category_id" name="category_id" required>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category['id'] ?>" <?= $category['id'] == $selectedTask['category_id'] ? 'selected' : '' ?>><?= $category['title'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <!-- Status field -->
                <div class="col-12 col-md-6 mb-3">
                    <label for="status">Статус</label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="Новое" <?= $selectedTask['status'] == 'Новое' ? 'selected' : '' ?>>Новое</option>
                        <option value="Выполнено" <?= $selectedTask['status'] == 'Выполнено' ? 'selected' : '' ?>>Выполнено</option>
                        <option value="Архив" <?= $selectedTask['status'] == 'Архив' ? 'selected' : '' ?>>Архив</option>
                    </select>
                </div>
            </div>
            <div class="mb-3">
                <label for="status">Клиент</label>
                <select class="form-control" id="client_id" name="client_id" required>
                    <?php foreach ($clients as $client): ?>
                        <option value="<?= $client['id'] ?>" <?= $client['id'] == $selectedTask['client_id'] ? 'selected' : '' ?>><?= $client['full_name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="row">
                <div class="col-12 col-md-6 mb-3">
                    <label for="tags">Тэги</label>
                    <div class="tags-container form-control">
                        <?php
                        $tagNames = array_map(function ($tag) {
                            return $tag['name'];
                        }, $tags);
                        foreach ($tagNames as $tagName) {
                            echo "<div class='tag'>
                                    <span>$tagName</span>
                                    <button type='button'>×</button>
                                </div>";
                        }
                        ?>
                        <input class="form-control" type="text" id="tag-input">
                    </div>
                    <input class="form-control" type="hidden" name="tags" id="hidden-tags" value="<?= htmlspecialchars(implode(', ', $tagNames)) ?>">
                </div>
                        
                <div class="col-12 col-md-6 mb-3">
                    <label for="description">Описание</label>
                    <textarea class="form-control" id="description" name="description" rows="3"><?php echo htmlspecialchars($selectedTask['description'] ?? ''); ?></textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <button type="submit" class="b">Редактировать</button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    const tagInput = document.querySelector('#tag-input');
    const tagsContainer = document.querySelector('.tags-container');
    const hiddenTags = document.querySelector('#hidden-tags');
    const existingTags = '<?= htmlspecialchars(isset($selectedTask['tags']) ? $selectedTask['tags'] : '') ?>';

    function createTag(text) {
        const tag = document.createElement('div');
        tag.classList.add('tag');
        const tagText = document.createElement('span');
        tagText.textContent = text;

        const closeButton = document.createElement('button');
        closeButton.innerHTML = '&times;';

        closeButton.addEventListener('click', () => {
            tagsContainer.removeChild(tag);
            updateHiddenTags();
        });

        tag.appendChild(tagText);
        tag.appendChild(closeButton);

        return tag;
    }

    function updateHiddenTags(){
        const tags = tagsContainer.querySelectorAll('.tag span');
        const tagText = Array.from(tags).map(tag => tag.textContent);
        hiddenTags.value = tagText.join(',');
    }

    tagInput.addEventListener('input', (e) => {
        if(e.target.value.includes(',')){
            const tagText = e.target.value.slice(0, -1).trim();
            if (tagText.length > 1) {
                const tag = createTag(tagText);
                tagsContainer.insertBefore(tag, tagInput);
                updateHiddenTags();
            }
            e.target.value = '';
        }
    });

    tagsContainer.querySelectorAll('.tag button').forEach(button =>{
        button.addEventListener('click', () => {
            tagsContainer.removeChild(button.parentElement);
            updateHiddenTags();
        });
    });
</script>
<?php 
$content = ob_get_clean();
include 'app/crm/layout.php'; 
?>