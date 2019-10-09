let SETTINGS;
function getSettings() {
    $.ajax('index.php?r=apples%2Fsettings', {
        type: 'POST',
        success: function (data) {
            SETTINGS = data;
        },
        error: function () {
            SETTINGS = [];
        }
    });
}
getSettings();

const initApplesPage = function () {

    let appleCards = $('.apple-cards');

    appleCards.on('click', '.fall', function () {
        let self = this;

        $.ajax('index.php?r=apples%2Ffall', {
            type: 'POST',
            data: {appleId: $(this).data('id')},
            success: function (data) {
                if (data.success) {
                    $(self).hide();
                    $(self).parent().find('.eat-block').show();
                    $(self).parent().parent().find('.status').text(SETTINGS['statuses'][data.status]);
                } else {
                    alert(data.reason);
                }
            },
            error: function (e) {
                console.log(e);
            }
        });
    });

    $(appleCards).on('click', '.eat', function () {
        let self = this;
        let block = $(self).closest('.apple-card');

        $.ajax('index.php?r=apples%2Feat', {
            type: 'POST',
            data: {
                appleId: $(this).data('id'),
                percent: $(self).parent().find('.percent-val').val(),
            },
            success: function (data) {
                if (data.success) {
                    if (data.size <= 0) {
                        block.remove();
                    } else {
                        block.find('.percent-eat').text('Размер: ' + data.size);
                    }
                } else {
                    alert(data.reason);
                }
            },
            error: function (e) {
                console.log(e);
            }
        });
    });

    $(appleCards).on('keyup', '.percent-val', function () {
        $(this).val($(this).val().replace(/[^.\d]+/g,""));
    });

    $('.add-apples').click(function () {
        $.ajax('index.php?r=apples%2Fcreate', {
            type: 'POST',
            success: function (data) {
                if (data.success) {
                    data.apples.forEach(function (apple) {
                        renderAppleCard(apple);
                    });
                } else {
                    alert(data.reason);
                }
            },
            error: function (e) {
                console.log(e);
            }
        });
    });

    function renderAppleCard(apple) {
        let buttons = `
            <button class="btn btn-info fall" data-id="${apple.id}">Упасть</button>
            <div class="eat-block" style="display: none;">
                <button class="btn btn-info eat" data-id="${apple.id}">Съесть</button>
                <input class="form-control percent-val" name="percent" type="text" value="25" data-id="${apple.id}">
                <label for="percent">%</label>
            </div>`;
        let card = $(`
            <div class="apple-card">
                <div class="info">
                    <div class="color">Цвет: ${apple.color}</div>
                    <div class="status">Статус: ${SETTINGS['statuses'][apple.status]}</div>
                    <div class="percent-eat">Размер: ${apple.percent_eat / 100}</div>
                </div>
                <div class="buttons">${buttons}</div>
            </div>`);

        appleCards.append(card);
    }

}
