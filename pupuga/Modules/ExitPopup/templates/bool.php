<input class="input-field input-field--checkbox <?php if (isset($params['field']['class']) && $params['field']['class'] !== '') : ?>input-field--<?php echo $params['field']['class'] ?><?php endif ?>"
       type="checkbox"
       name="<?php echo $params['key'] ?>"
       data-type="<?php echo $params['type'] ?>"
       <?php if(isset($params['field']['marker']) && $params['field']['marker'] !== '') : ?> data-slug="<?php echo $params['field']['marker'] ?>"<?php endif ?>
       <?php if($params['field']['value']): ?> checked<?php endif ?>>