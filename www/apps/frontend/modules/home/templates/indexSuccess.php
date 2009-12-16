<?php use_helper('Form') ?>
<?php use_helper('I18N') ?>

<?php slot('header-extra') ?>
  <div id="contact-links">
    <ul>
      <li class="blog"><a href="<?php echo __('http://blog.voota.es/es') ?>"><?php echo __('Voota tiene un blog') ?></a></li>
      <li class="twitter"><a href="<?php echo __('http://twitter.com/Voota') ?>"><?php echo __('Voota en Twitter') ?></a></li>
      <li class="facebook"><a href="<?php echo __('http://www.facebook.com/Voota') ?>"><?php echo __('Voota en Facebook') ?></a></li>
    </ul>
  </div>
<?php end_slot('logged') ?>

<h2 id="summary">
  <ul>
    <li><?php echo __('Coomparte opiniones sobre los políticos de España.') ?></li>
    <li><?php echo __('De momento: Congreso, Senado y Parlamento de Cataluña.') ?></li>
    <li><?php echo __('Los políticos más votados de hoy:') ?></li>
  </ul>
</h2>

<div id="content">
  <div id="politicians-most-voted" class="list-mini">
    <ul>
      <li>
        <div class="avatar">
          <img src="/images/proto/politico.png" alt="" width="" height="" />
      	</div>
      	<h4 class="name"><a href="#">Manuel Fraga Iribarne (PP)</a></h4>
      	<p class="votes">
      	  <span class="graph">
      	    <img src="/images/proto/graficos.jpg" alt="gráfica de votos" width="114" height="35" />
      	  </span>
      	  <span class="votes-count">9/10</span>
      	</p>
      </li>
      <li>
        <div class="avatar">
          <img src="/images/proto/politico.png" alt="" width="" height="" />
      	</div>
      	<h4 class="name"><a href="#">Manuel Fraga Iribarne (PP)</a></h4>
      	<p class="votes">
      	  <span class="graph">
      	    <img src="/images/proto/graficos.jpg" alt="gráfica de votos" width="114" height="35" />
      	  </span>
      	  <span class="votes-count">9/10</span>
      	</p>
      </li>
      <li>
        <div class="avatar">
          <img src="/images/proto/politico.png" alt="" width="" height="" />
      	</div>
      	<h4 class="name"><a href="#">Manuel Fraga Iribarne (PP)</a></h4>
      	<p class="votes">
      	  <span class="graph">
      	    <img src="/images/proto/graficos.jpg" alt="gráfica de votos" width="114" height="35" />
      	  </span>
      	  <span class="votes-count">9/10</span>
      	</p>
      </li>
      <li>
        <div class="avatar">
          <img src="/images/proto/politico.png" alt="" width="" height="" />
      	</div>
      	<h4 class="name"><a href="#">Manuel Fraga Iribarne (PP)</a></h4>
      	<p class="votes">
      	  <span class="graph">
      	    <img src="/images/proto/graficos.jpg" alt="gráfica de votos" width="114" height="35" />
      	  </span>
      	  <span class="votes-count">9/10</span>
      	</p>
      </li>
      <li>
        <div class="avatar">
          <img src="/images/proto/politico.png" alt="" width="" height="" />
      	</div>
      	<h4 class="name"><a href="#">Manuel Fraga Iribarne (PP)</a></h4>
      	<p class="votes">
      	  <span class="graph">
      	    <img src="/images/proto/graficos.jpg" alt="gráfica de votos" width="114" height="35" />
      	  </span>
      	  <span class="votes-count">9/10</span>
      	</p>
      </li>
      <li>
        <div class="avatar">
          <img src="/images/proto/politico.png" alt="" width="" height="" />
      	</div>
      	<h4 class="name"><a href="#">Manuel Fraga Iribarne (PP)</a></h4>
      	<p class="votes">
      	  <span class="graph">
      	    <img src="/images/proto/graficos.jpg" alt="gráfica de votos" width="114" height="35" />
      	  </span>
      	  <span class="votes-count">9/10</span>
      	</p>
      </li>
    </ul>
  </div>
  
  <div class="search">
    <?php echo form_tag('@search') ?>
      <p>
        <label for="q_1">¡Buusca!</label>
      </p>
      <p>
        <?php echo input_tag('q', $sf_params->get('q'), array('id' => 'q_1')) ?>
        <br />
        <span class="hints">Político, partido o institución</span>
      </p>
      <p>
        <?php echo submit_tag('Buscar', array('class' => 'button')) ?>
      </p>
    </form>
  </div>
</div>