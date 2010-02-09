<?php if ($sf_user->isFacebookConnected()): ?>
  <p>
    <img src="/images/icoFacebook.png" alt="Facebook Connect" />
    Conectado a Facebook como: <strong><fb:name uid="<?php echo $sf_user->getProfile()->getFacebookUid() ?>" useyou="false" linked="false"></fb:name></strong>
    <button>Desconectar</button>
  </p>
  <p>Actualizar tu muro de Facebook:</p>
  <ul>
    <li>
      <p>
        <input type="checkbox" value="1" name="profile[fb_publish_vootos]" id="profile_fb_publish_vootos" />
        <label for="profile_fb_publish_vootos">Cada vez que agregas un Vooto</label>
      </p>
      <?php // if (usuario_tiene_último_vooto): ?>
        <p>
          Tu último Vooto:
          <br />
          <q>Es un tío genial. Invitar a cañas desde ya</q>
        </p>
      <?php // endif ?>
    </li>
    <li>
      <p>
        <input type="checkbox" value="1" name="profile[fb_publish_vootos_otros]" id="profile_fb_publish_vootos_otros" />
        <label for="profile_fb_publish_vootos_otros">Cada vez que opinas sobre un Vooto hecho por otro usuario</label>
      </p>
      <?php // if (usuario_tiene_último_comentario_sobre_vooto): ?>
        <p>
          Tu última opinión sobre un Vooto:
          <br />
          <q>A mí me parece que se ha ido de las manos tío, pero no voy a ser yo el que te pare los pies, que lo sepas manoteras</q>
        </p>
      <?php // endif ?>
    </li>
    <li>
      <p>
        <input type="checkbox" value="1" name="profile[fb_publish_cambios_perfil]" id="profile_fb_publish_cambios_perfil" />
        <label for="profile_fb_publish_cambios_perfil">Cada vez que haces cambios en tu perfil (tu foto o sobre ti)</label>
      </p>
    </li>
  </ul>
<?php else: ?>
  Desconectado
<?php endif ?>