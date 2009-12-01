<?php use_helper('I18N') ?>

<h2>Contacta con Voota</h2>
<p class="success-msg">Gracias por tu mensaje</p>

<div id="content">
  <p class="next-step-msg">¿Qué hacemos ahora? Tú dirás.</p>
  <p class="next-step-msg">¿Nos vamos a la <a href="/">home de Voota</a>?</p>
  <p class="next-step-msg">¿Una vuelta por el <a href="/es/politicos">ranking de políticos</a> quizás?</p>

  <form>
    <dl>
      <dt><label for="nombre">Tu nombre:</label></dt>
      <dd><input type="text" name="nombre" value="" /> <span class="hints">(Opcional)</span></dd>
      
      <dt><label for="email">Email:</label></dt>
      <dd><input type="text" name="email" value="" /></dd>
      
      <dt><label for="topic">¿De qué se trata?</label></dt>
      <dd>
        <select name="topic">
          <option value="suggestion">Sugerencia</option>
          <option value="problem">Problema</option>
        </select>
        <span class="hints">(Opcional)</span>
      </dd>

      <dt><label for="body">Tu mensaje:</label></dt>
      <dd><textarea name="body" rows="12" cols="60"></textarea></dd>
    </dl>
    <p class="submit">
      <input type="submit" name="enviar" value="Enviar" />
    </p>
  </form>
</div>

<div id="sidebar">
  <div class="box box-contact">
    <div class="box-inner">
      <h2>info (arroba) voota.es</h2>
      <ul>
        <li class="blog"><a href="http://blog.voota.es/">Nuestro blog</a></li>
        <li class="twitter"><a href="http://twitter.com/Voota">Voota en Twitter</a></li>
        <li class="facebook"><a href="http://www.facebook.com/Voota">Voota en Facebook</a></li>
      </ul>
    </div>
  </div>
</div>