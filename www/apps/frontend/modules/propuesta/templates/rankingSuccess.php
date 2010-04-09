  <div id="main">
    <div id="main-inner">
      <script type="text/javascript" charset="utf-8">
        $(document).ready(function (){
          $('a.tooltip_propuesta').each(function(){
            $(this).qtip({
              content: '<p><strong>' + $(this).attr('title').split('|')[0] + '</strong></p><p>' + $(this).attr('title').split('|')[1] + '</p>',
              position: { corner: { target: 'rightBottom', tooltip_propuesta: 'topMiddle' } },
              style: { name: 'light' }
            });
          });
        });
      </script>

      <h2>Ranking de propuestas: de momento 358</h2>

      <table border="0" cellpadding="0" cellspacing="0">
        <thead>
          <tr>
            <th class="ranking"></th>
            <th class="position"></th>
            <th class="photo"></th>
            <th class="name">Nombre</th>
            <th class="positive-votes">
            	<a id="positive-votes-link" href="/frontend_dev.php/es/propuestas?o=pa" title="Ordenar por votos positivos: los que tienen menos votos positivos primero">Votos +</a>
            	<!-- OJO: El texto del tooltip cambia si varía el orden. Ej: -->
            	<!-- <a href="/frontend_dev.php/es/propuestas?o=pa" title="Ordenar por votos positivos: los que tienen más votos positivos primero">Votos +</a> -->
            	<img alt="yeah" src="/images/icoUp20px.gif" />
            	<img alt="descendente" src="/images/flechaDown.gif" />      	    	
            	<div id="positive-votes-tooltip" style="display: none">
                <p><strong>Ordenar por votos positivos:</strong> los que tienen menos votos positivos primero</p>
              </div>
            </th>
            <th class="negative-votes">
            	<a href="/frontend_dev.php/es/propuestas?o=nd" title="Ordenar por votos negativos: los que tienen más votos negativos primero">Votos -</a>
            	<!-- OJO: El texto del tooltip cambia si varía el orden. Ej: -->
            	<!-- <a href="/frontend_dev.php/es/propuestas?o=nd" title="Ordenar por votos negativos: los que tienen menos votos negativos primero">Votos -</a> -->
            	<img alt="buu" src="/images/icoDown20px.gif" />
            </th>
            <th class="date">
              <a href="/frontend_dev.php/es/propuestas?o=fd" title="Ordenar por fecha: las más recientes primero">Fecha</a>
              <!-- OJO: El texto del tooltip cambia si varía el orden. Ej: -->
              <!-- <a href="/frontend_dev.php/es/propuestas?o=fd" title="Ordenar por fecha: las más antiguas primero">Fecha</a> -->
            </th>
          </tr>
        </thead>

        <tfoot>
          <tr>
            <td class="ranking"></td>
            <td class="position"></td>
            <td class="photo"></td>
            <td class="name"></td>
            <td class="positive-votes">
              Total
              <img alt="yeah" src="/images/icoUp20px.gif" />
              528
            </td>
            <td class="negative-votes">
            	Total
            	<img alt="buu" src="/images/icoDown20px.gif" />
            	414
            </td>
            <td class="date"></td>
          </tr>
        </tfoot>

        <tbody>
          <tr class="odd">
      	    <td class="ranking">
      	      <span title="Evolución del número de votos positivos por mes (último punto = mes actual)" id="sparkline_84">
      	        <img src="/images/proto/sparkline.png">
      	      </span>
            </td>
      	    <td class="position">1.</td>
      	    <td class="photo">
              <img alt="Foto de François Derbaix" src="http://images.voota.es/usuarios/cc_s_Fran%C3%A7ois-Derbaix-0747.jpg" />
            </td>
            <td class="name">
              <a href="/frontend_dev.php/es/propuesta/implantacion-subsidio" title="Sobre esta propuesta:|En Bélgica se aprobó la implantación de un subsidio de paro indefinido (también llamado 'minimex') donde todas las personas en edad de trabajar que no tuviesen trabajo recibían una prestación fija de dinero." class="tooltip_propuesta">Implantación de un subsidio de...</a>
            </td>
            <td class="positive-votes">68</td>
            <td class="negative-votes">33</td>
            <td class="date">07/06/2010</td>
          </tr>
          <tr class="even">
      	    <td class="ranking">
      	      <span title="Evolución del número de votos positivos por mes (último punto = mes actual)" id="sparkline_1171">
      	        <img src="/images/proto/sparkline.png">
      	      </span>
            </td>
        	  <td class="position">2.</td>
        	  <td class="photo">
              <img alt="Foto de Pablo Gavilán" src="http://images.voota.es/usuarios/v.png" />
            </td>
            <td class="name">
              <a href="/frontend_dev.php/es/propuesta/alternativas-impuestos" class="tooltip_propuesta" title="#propuesta_2">Alternativas a los impuestos par...</a>
              <div id="propuesta_2" style="display: none">
                <p><strong>Sobre esta propuesta:</strong></p>
                <p>En Bélgica se aprobó la implantación de un subsidio de paro indefinido (también llamado 'minimex') donde todas las personas en edad de trabajar que no tuviesen trabajo recibían una prestación fija de dinero.</p>
              </div>
            </td>
            <td class="positive-votes">60</td>
            <td class="negative-votes">29</td>
            <td class="date">07/06/2010</td>
          </tr>
          <tr class="odd">
      	    <td class="ranking">
      	      <span title="Evolución del número de votos positivos por mes (último punto = mes actual)" id="sparkline_84">
      	        <img src="/images/proto/sparkline.png">
      	      </span>
            </td>
      	    <td class="position">3.</td>
      	    <td class="photo">
              <img alt="Foto de François Derbaix" src="http://images.voota.es/usuarios/cc_s_Fran%C3%A7ois-Derbaix-0747.jpg" />
            </td>
            <td class="name">
              <a href="/frontend_dev.php/es/propuesta/implantacion-subsidio" title="#propuesta_3" class="tooltip_propuesta">Implantación de un subsidio de...</a>
              <div id="propuesta_3" style="display: none">
                <p><strong>Sobre esta propuesta:</strong></p>
                <p>En Bélgica se aprobó la implantación de un subsidio de paro indefinido (también llamado 'minimex') donde todas las personas en edad de trabajar que no tuviesen trabajo recibían una prestación fija de dinero.</p>
              </div>
            </td>
            <td class="positive-votes">68</td>
            <td class="negative-votes">33</td>
            <td class="date">07/06/2010</td>
          </tr>
          <tr class="even">
      	    <td class="ranking">
      	      <span title="Evolución del número de votos positivos por mes (último punto = mes actual)" id="sparkline_1171">
      	        <img src="/images/proto/sparkline.png">
      	      </span>
            </td>
        	  <td class="position">4.</td>
        	  <td class="photo">
              <img alt="Foto de Pablo Gavilán" src="http://images.voota.es/usuarios/v.png" />
            </td>
            <td class="name">
              <a href="/frontend_dev.php/es/propuesta/alternativas-impuestos" class="tooltip_propuesta" title="#propuesta_4">Alternativas a los impuestos par...</a>
              <div id="propuesta_4" style="display: none">
                <p><strong>Sobre esta propuesta:</strong></p>
                <p>En Bélgica se aprobó la implantación de un subsidio de paro indefinido (también llamado 'minimex') donde todas las personas en edad de trabajar que no tuviesen trabajo recibían una prestación fija de dinero.</p>
              </div>
            </td>
            <td class="positive-votes">60</td>
            <td class="negative-votes">29</td>
            <td class="date">07/06/2010</td>
          </tr>
          <tr class="odd">
      	    <td class="ranking">
      	      <span title="Evolución del número de votos positivos por mes (último punto = mes actual)" id="sparkline_84">
      	        <img src="/images/proto/sparkline.png">
      	      </span>
            </td>
      	    <td class="position">5.</td>
      	    <td class="photo">
              <img alt="Foto de François Derbaix" src="http://images.voota.es/usuarios/cc_s_Fran%C3%A7ois-Derbaix-0747.jpg" />
            </td>
            <td class="name">
              <a href="/frontend_dev.php/es/propuesta/implantacion-subsidio" title="#propuesta_5" class="tooltip_propuesta">Implantación de un subsidio de...</a>
              <div id="propuesta_5" style="display: none">
                <p><strong>Sobre esta propuesta:</strong></p>
                <p>En Bélgica se aprobó la implantación de un subsidio de paro indefinido (también llamado 'minimex') donde todas las personas en edad de trabajar que no tuviesen trabajo recibían una prestación fija de dinero.</p>
              </div>
            </td>
            <td class="positive-votes">68</td>
            <td class="negative-votes">33</td>
            <td class="date">07/06/2010</td>
          </tr>
          <tr class="even">
      	    <td class="ranking">
      	      <span title="Evolución del número de votos positivos por mes (último punto = mes actual)" id="sparkline_1171">
      	        <img src="/images/proto/sparkline.png">
      	      </span>
            </td>
        	  <td class="position">6.</td>
        	  <td class="photo">
              <img alt="Foto de Pablo Gavilán" src="http://images.voota.es/usuarios/v.png" />
            </td>
            <td class="name">
              <a href="/frontend_dev.php/es/propuesta/alternativas-impuestos" class="tooltip_propuesta" title="#propuesta_6">Alternativas a los impuestos par...</a>
              <div id="propuesta_6" style="display: none">
                <p><strong>Sobre esta propuesta:</strong></p>
                <p>En Bélgica se aprobó la implantación de un subsidio de paro indefinido (también llamado 'minimex') donde todas las personas en edad de trabajar que no tuviesen trabajo recibían una prestación fija de dinero.</p>
              </div>
            </td>
            <td class="positive-votes">60</td>
            <td class="negative-votes">29</td>
            <td class="date">07/06/2010</td>
          </tr>
          <tr class="odd">
      	    <td class="ranking">
      	      <span title="Evolución del número de votos positivos por mes (último punto = mes actual)" id="sparkline_84">
      	        <img src="/images/proto/sparkline.png">
      	      </span>
            </td>
      	    <td class="position">7.</td>
      	    <td class="photo">
              <img alt="Foto de François Derbaix" src="http://images.voota.es/usuarios/cc_s_Fran%C3%A7ois-Derbaix-0747.jpg" />
            </td>
            <td class="name">
              <a href="/frontend_dev.php/es/propuesta/implantacion-subsidio" title="#propuesta_7" class="tooltip_propuesta">Implantación de un subsidio de...</a>
              <div id="propuesta_7" style="display: none">
                <p><strong>Sobre esta propuesta:</strong></p>
                <p>En Bélgica se aprobó la implantación de un subsidio de paro indefinido (también llamado 'minimex') donde todas las personas en edad de trabajar que no tuviesen trabajo recibían una prestación fija de dinero.</p>
              </div>
            </td>
            <td class="positive-votes">68</td>
            <td class="negative-votes">33</td>
            <td class="date">07/06/2010</td>
          </tr>
          <tr class="even">
      	    <td class="ranking">
      	      <span title="Evolución del número de votos positivos por mes (último punto = mes actual)" id="sparkline_1171">
      	        <img src="/images/proto/sparkline.png">
      	      </span>
            </td>
        	  <td class="position">8.</td>
        	  <td class="photo">
              <img alt="Foto de Pablo Gavilán" src="http://images.voota.es/usuarios/v.png" />
            </td>
            <td class="name">
              <a href="/frontend_dev.php/es/propuesta/alternativas-impuestos" class="tooltip_propuesta" title="#propuesta_8">Alternativas a los impuestos par...</a>
              <div id="propuesta_8" style="display: none">
                <p><strong>Sobre esta propuesta:</strong></p>
                <p>En Bélgica se aprobó la implantación de un subsidio de paro indefinido (también llamado 'minimex') donde todas las personas en edad de trabajar que no tuviesen trabajo recibían una prestación fija de dinero.</p>
              </div>
            </td>
            <td class="positive-votes">60</td>
            <td class="negative-votes">29</td>
            <td class="date">07/06/2010</td>
          </tr>
          <tr class="odd">
      	    <td class="ranking">
      	      <span title="Evolución del número de votos positivos por mes (último punto = mes actual)" id="sparkline_84">
      	        <img src="/images/proto/sparkline.png">
      	      </span>
            </td>
      	    <td class="position">9.</td>
      	    <td class="photo">
              <img alt="Foto de François Derbaix" src="http://images.voota.es/usuarios/cc_s_Fran%C3%A7ois-Derbaix-0747.jpg" />
            </td>
            <td class="name">
              <a href="/frontend_dev.php/es/propuesta/implantacion-subsidio" title="#propuesta_9" class="tooltip_propuesta">Implantación de un subsidio de...</a>
              <div id="propuesta_9" style="display: none">
                <p><strong>Sobre esta propuesta:</strong></p>
                <p>En Bélgica se aprobó la implantación de un subsidio de paro indefinido (también llamado 'minimex') donde todas las personas en edad de trabajar que no tuviesen trabajo recibían una prestación fija de dinero.</p>
              </div>
            </td>
            <td class="positive-votes">68</td>
            <td class="negative-votes">33</td>
            <td class="date">07/06/2010</td>
          </tr>
          <tr class="even">
      	    <td class="ranking">
      	      <span title="Evolución del número de votos positivos por mes (último punto = mes actual)" id="sparkline_1171">
      	        <img src="/images/proto/sparkline.png">
      	      </span>
            </td>
        	  <td class="position">10.</td>
        	  <td class="photo">
              <img alt="Foto de Pablo Gavilán" src="http://images.voota.es/usuarios/v.png" />
            </td>
            <td class="name">
              <a href="/frontend_dev.php/es/propuesta/alternativas-impuestos" class="tooltip_propuesta" title="#propuesta_10">Alternativas a los impuestos par...</a>
              <div id="propuesta_10" style="display: none">
                <p><strong>Sobre esta propuesta:</strong></p>
                <p>En Bélgica se aprobó la implantación de un subsidio de paro indefinido (también llamado 'minimex') donde todas las personas en edad de trabajar que no tuviesen trabajo recibían una prestación fija de dinero.</p>
              </div>
            </td>
            <td class="positive-votes">60</td>
            <td class="negative-votes">29</td>
            <td class="date">07/06/2010</td>
          </tr>
        </tbody>
      </table>

      <p class="pagination">
        <a class="numerosPag" href="/frontend_dev.php/es/propuestas?page=1&amp;o=pd">&laquo;Anterior</a>  
        1
        <a class="numerosPag" href="/frontend_dev.php/es/propuestas?page=2&amp;o=pd">2</a>
        <a class="numerosPag" href="/frontend_dev.php/es/propuestas?page=3&amp;o=pd">3</a>
        <a class="numerosPag" href="/frontend_dev.php/es/propuestas?page=4&amp;o=pd">4</a>
        <a class="numerosPag" href="/frontend_dev.php/es/propuestas?page=5&amp;o=pd">5</a>
        ...
        <a class="numerosPag" href="/frontend_dev.php/es/propuestas?page=494&amp;o=pd">494</a>
        <a class="numerosPag" href="/frontend_dev.php/es/propuestas?page=2&amp;o=pd">Siguiente&raquo;</a>
      </p>
    </div>
  </div>