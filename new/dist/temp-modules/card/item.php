<div class="item">
    <div class="content">
        <?php if ($cardArray[ 'imgs']): ?>
        <div class="cards-gallery">
            <div class="cards-gallery__inner">
                <?php foreach ($cardArray[ 'imgs'] as $key=>$value): ?>
                <a class="cards-gallery__item" href="<?php if $value['url']: ?>" data-fancybox="<?php if ($cardArray['id']): ?>">
                    <div class="cards-gallery__img-wrapper">
                        <img class="cards-gallery__img" src="<?php if $value['url']: ?>" alt="" role="presentation" />
                        <?php if $key==3 : ?>
                        <div class="cards-gallery__more">
                            <div class="cards-gallery__more-icon">
                                <svg class="icon icon-camera cards-gallery__more-icon" viewBox="0 0 54 46">
                                    <use xlink:href="/app/icons/sprite.svg#camera"></use>
                                </svg>
                            </div>
                            <div class="cards-gallery__more-text">Еще 7 фото</div>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="cards-gallery__line"></div>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
        <div class="cards-top">
            <?php if ($cardArray[ 'name']): ?><span class="cards-top__item-name"> <span class="cards-top__item-name-inner"><?php if ($cardArray['userOnline']): ?><span class="cards-top__user-online user-online"></span>
            <?php endif; ?>
            <?php if ($cardArray[ 'checkbox']): ?>
            <label class="checkbox cards-top__checkbox">
                <input class="checkbox__input j-cb-share-need" type="checkbox" name="share-need" /><span class="checkbox__control"><span class="checkbox__icon"><svg class="icon icon-check " viewBox="0 0 16 16"><use xlink:href="/app/icons/sprite.svg#check"></use></svg></span></span>
            </label>
            <?php endif; ?>
            <a class="cards-top__item-name-text" href="<?=$cardArray['url']; ?>">
                <?=$cardArray[ 'name']; ?>
            </a>
            </span>
            </span>
            <?php endif; ?>
            <?php if ($cardArray[ 'quantityLeft'] || $cardArray[ 'minLot'] || $cardArray[ 'photos']): ?>
            <div class="cards-top__quantity">
                <?php if ($cardArray[ 'quantityLeft']): ?>
                <div class="cards-top__quantity-left">
                    <?=$cardArray[ 'quantityLeft']; ?>
                        <?php if ($cardArray[ 'quantityPurchased']): ?><span class="cards-top__quantity-purchased">&nbsp;(<?=$cardArray['quantityPurchased']; ?>)</span>
                        <?php endif; ?>
                </div>
                <?php endif; ?>
                <?php if ($cardArray[ 'minLot']): ?>
                <div class="cards-top__min-lot"> <span class="cards-top__min-lot-left"><?=$cardArray['minLot'][0]; ?></span><span class="cards-top__min-lot-separator">/</span><span class="cards-top__min-lot-multiplicity"><?=$cardArray['minLot'][1]; ?></span>
                </div>
                <?php endif; ?>
                <?php if ($cardArray[ 'photos']): ?>
                <div class="cards-top__photos">
                    <svg class="icon icon-cameraSharp cards-top__photos-icon" viewBox="0 0 17 17">
                        <use xlink:href="/app/icons/sprite.svg#cameraSharp"></use>
                    </svg>
                </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>
        <?php if ($cardArray[ 'costMain'] || $cardArray[ 'costOld']): ?>
        <div class="cards-cost">
            <?php if ($cardArray[ 'costMain']): ?>
            <div class="cards-cost__main"><span class="cards-cost__price <?php if ($cardArray['costMain']['highlight']) echo 'cards-cost__price 'cards-cost__price_red '?>"><?=$cardArray['costMain']['price']; ?><span class="cards-cost__symbol">&nbsp;₽</span></span>
                <?php if ($cardArray[
                'costMain'][ 'payment']): ?><span class="cards-cost__payment"> <?php if ($cardArray['costMain']['payment'] == 'icon'): ?><svg class="icon icon-money " viewBox="0 0 20 20"><use xlink:href="/app/icons/sprite.svg#money"></use></svg><?php else; ?><?=$cardArray['costMain']['payment']; ?><?php endif; ?></span>
                <?php
                endif; ?>
                    <?php if ($cardArray[ 'costMain'][ 'truck']): ?><span class="cards-cost__truck"> <svg class="icon icon-truck cards-cost__truck-icon" viewBox="0 0 30 18"><use xlink:href="/app/icons/sprite.svg#truck"></use></svg></span>
                    <?php endif; ?>
            </div>
            <?php endif; ?>
            <?php if ($cardArray[ 'costOld']): ?>
            <div class="cards-cost__old"><span class="cards-cost__price cards-cost__price_cross-out <?php if ($cardArray['costOld']['highlight']) echo 'cards-cost__price 'cards-cost__price_red '?>"><?=$cardArray['costOld']['price']; ?><span class="cards-cost__symbol">&nbsp;₽</span></span>
                <?php
                if ($cardArray[ 'costOld'][ 'payment']): ?><span class="cards-cost__payment"> <?php if ($cardArray['costOld']['payment'] == 'icon'): ?><svg class="icon icon-money " viewBox="0 0 20 20"><use xlink:href="/app/icons/sprite.svg#money"></use></svg><?php else; ?><?=$cardArray['costOld']['payment']; ?><?php endif; ?></span>
                    <?php
                    endif; ?>
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>
        <?php if ($cardArray[ 'properties']): ?>
        <div class="cards-properties">
            <?php foreach ($cardArray[ 'properties'] as $value): ?>
            <div class="cards-properties__properties-item">
                <?=$value; ?>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
        <div class="cards-bottom">
            <?php if ($cardArray[ 'comment'] || $cardArray[ 'categories']): ?>
            <div class="cards-bottom__comment"><span class="cards-bottom__comment-text"><?=$cardArray['comment']; ?></span>
                <?php if ($cardArray[ 'categories']): ?><span class="cards-bottom__comment-categories"><?=$cardArray['categories']; ?></span>
                <?php endif; ?>
            </div>
            <?php endif; ?>
            <?php if ($cardArray[ 'urgent']): ?>
            <div class="cards-bottom__urgency cards-bottom__urgency cards-bottom__urgency_<?=$cardArray['urgent']['name']; ?>">
                <?=$cardArray[ 'urgent'][ 'value']; ?>
            </div>
            <?php endif; ?>
            <?php if ($cardArray[ 'city']): ?>
            <div class="cards-bottom__city">
                <?=$cardArray[ 'city']; ?>
            </div>
            <?php endif; ?>
            <?php if ($cardArray[ 'days']): ?>
            <div class="cards-bottom__days">
                <?=$cardArray[ 'days']; ?>
            </div>
            <?php endif; ?>
            <?php if ($cardArray[ 'badge'] || $cardArray[ 'user'] || $cardArray[ 'category']): ?>
            <div class="cards-bottom__right">
                <?php if ($cardArray[ 'badge']): ?>
                <?php if ($cardArray[ 'badge'][ 'link']): ?><a class="cards-bottom__badge" href="<?=$cardArray['badge']['link']; ?>"><span><?=$cardArray['badge']['text']; ?></span></a>
                <?php else: ?>
                <div class="cards-bottom__badge"><span><?=$cardArray['badge']['text']; ?></span>
                </div>
                <?php endif; ?>
                <?php endif; ?>
                <?php if ($cardArray[ 'user']): ?>
                <div class="cards-bottom__user"><span class="cards-bottom__user-name <?php if ($cardArray['user']['online']){ echo 'user-online' } ?>"><?=$cardArray['user']['name']; ?></span><span class="cards-bottom__user-avatar"><?php if ($cardArray['avatar']): ?><img src="<?=$cardArray['user']['avatar']; ?>"/><?php else: ?><svg class="icon icon-noAvatar cards-bottom__user-avatar-icon" viewBox="0 0 16 16"><use xlink:href="/app/icons/sprite.svg#noAvatar"></use></svg><?php endif; ?></span>
                </div>
                <?php endif; ?>
                <?php if ($cardArray[ 'category']): ?>
                <div class="cards-bottom__category">
                    <div class="cards-bottom__category-text">
                        <?=$cardArray[ 'category']; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>
        <div class="cards-info">
            <?php if ($cardArray[ 'daysLeft'] || $cardArray[ 'views']): ?>
            <div class="cards-info__nums">
                <div class="cards-info__nums-inner">
                    <?php if ($cardArray[ 'daysLeft']): ?>
                    <div class="cards-info__nums-days"> <span class="cards-info__nums-days-text"> <span class="j-cards-nums-days"></span>
                        <?=$cardArray[ 'daysLeft']; ?>
                            &nbsp;дней</span>
                            <div class="cards-info__nums-days-scale"><span class="cards-info__nums-days-scale-thumb"></span>
                            </div>
                    </div>
                    <?php endif; ?>
                    <?php if ($cardArray[ 'views']): ?>
                    <div class="cards-info__nums-views">
                        <div class="cards-info__nums-views-img">
                            <svg class="icon icon-eye cards-info__nums-views-icon" viewBox="0 0 16 16">
                                <use xlink:href="/app/icons/sprite.svg#eye"></use>
                            </svg>
                        </div><span class="cards-info__nums-views-text"><?=$cardArray['views']; ?></span>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>
            <?php if ($cardArray[ 'btn']): ?>
            <div class="cards-info__action">
                <?php if ($cardArray[ 'btn'][ 'name']): ?>
                <?php if ($cardArray[ 'btn'][ 'isDropdown']): ?>
                <div class="cards-info__action-btn btn btn_blue btn btn_dropdown" data-btn="&lt;?=$cardArray['btn']['data']; ?&gt;"><span><?=$cardArray['btn']['name']; ?></span>
                    <svg class="icon icon-dropdown cards-info__action-btn-icon" viewBox="0 0 12 12">
                        <use xlink:href="/app/icons/sprite.svg#dropdown"></use>
                    </svg>
                </div>
                <?php else: ?>
                <div class="cards-info__action-btn btn btn_blue" data-btn="&lt;?=$cardArray['btn']['data']; ?&gt;"><span><?=$cardArray['btn']['name']; ?></span>
                </div>
                <?php endif; ?>
                <?php endif; ?>
                <?php if ($cardArray[ 'btn'][ 'offersNotify']): ?>
                <div class="badge-notify"><span>1</span>
                </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>
            <?php if ($cardArray[ 'status'] || $cardArray[ 'publicationDate']): ?>
            <div class="cards-info__status">
                <?php if ($cardArray[ 'status']): ?>
                <div class="cards-info__status-name">
                    <?php if ($cardArray[ 'status'][ 'name']): ?><span class="cards-info__status-name-text"><?=$cardArray['status']['name']; ?></span>
                    <?php endif; ?>
                    <?php if ($cardArray[ 'status'][ 'notify']): ?>
                    <div class="badge-notify"><span>&lt;?=$cardArray['btn']['data']; ?&gt;</span>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
                <?php if ($cardArray[ 'publicationDate']): ?>
                <div class="cards-info__status-published"><span class="cards-info__status-published-text"><?=$cardArray['publicationDate']; ?></span>
                </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>
            <?php if ($cardArray[ 'manage']): ?>
            <div class="cards-info__manage">
                <div class="cards-info__manage-inner">
                    <?php foreach ($cardArray[ 'manage'] as $val): ?>
                    <?php if ($val=='edit' ): ?>
                    <div class="cards-info__manage-item cards-info__manage-edit">
                        <svg class="icon icon-pencil cards-info__manage-item-icon" viewBox="0 0 15 15">
                            <use xlink:href="/app/icons/sprite.svg#pencil"></use>
                        </svg>
                    </div>
                    <?php endif; ?>
                    <?php if ($val=='open' ): ?>
                    <div class="cards-info__manage-item cards-info__manage-open j-open-offers">
                        <svg class="icon icon-pencilWrite cards-info__manage-item-icon" viewBox="0 0 16 16">
                            <use xlink:href="/app/icons/sprite.svg#pencilWrite"></use>
                        </svg>
                    </div>
                    <?php endif; ?>
                    <?php if ($val=='msg' ): ?>
                    <div class="cards-info__manage-item cards-info__manage-message">
                        <svg class="icon icon-mail cards-info__manage-item-icon" viewBox="0 0 16 16">
                            <use xlink:href="/app/icons/sprite.svg#mail"></use>
                        </svg>
                    </div>
                    <?php endif; ?>
                    <?php if ($val=='refresh' ): ?>
                    <div class="cards-info__manage-item cards-info__manage-refresh">
                        <svg class="icon icon-rotateArrow cards-info__manage-item-icon" viewBox="0 0 16 16">
                            <use xlink:href="/app/icons/sprite.svg#rotateArrow"></use>
                        </svg>
                    </div>
                    <?php endif; ?>
                    <?php if ($val=='warning' ): ?>
                    <div class="cards-info__manage-item cards-info__manage-warning">
                        <svg class="icon icon-warning cards-info__manage-item-icon" viewBox="0 0 16 16">
                            <use xlink:href="/app/icons/sprite.svg#warning"></use>
                        </svg>
                    </div>
                    <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="cards-info__menu">
                <svg class="icon icon-threeDot cards-info__menu-icon" viewBox="0 0 32 32">
                    <use xlink:href="/app/icons/sprite.svg#threeDot"></use>
                </svg>
            </div>
        </div>
    </div>
</div>