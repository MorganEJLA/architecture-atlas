import { createRoot, useMemo, useState } from '@wordpress/element';
import { __, _n, sprintf } from '@wordpress/i18n';
import { decodeEntities } from '@wordpress/html-entities';

const ALL = 0;
const NO_YEAR = 9999;

function fetchJson( url ) {
	return fetch( url ).then( ( response ) => {
		if ( ! response.ok ) {
			throw new Error( response.statusText );
		}
		return response.json();
	} );
}

function toYear( value ) {
	if ( value === '' || value === null || value === undefined ) {
		return null;
	}
	const year = Number( value );
	return Number.isNaN( year ) ? null : year;
}

const HEX_COLOR = /^#(?:[0-9a-fA-F]{3}|[0-9a-fA-F]{6})$/;

function toSwatches( acf ) {
	return [ 1, 2, 3 ]
		.map( ( number ) => ( {
			number,
			color: acf?.[ `swatch_${ number }` ],
		} ) )
		.filter(
			( swatch ) =>
				typeof swatch.color === 'string' &&
				HEX_COLOR.test( swatch.color )
		);
}

function prepare( movements ) {
	return movements
		.map( ( movement ) => ( {
			id: movement.id,
			link: movement.link,
			title: decodeEntities( movement.title.rendered ),
			start: toYear( movement.acf?.start_year ),
			end: toYear( movement.acf?.end_year ),
			placeIds: movement.atlas_place || [],
			swatches: toSwatches( movement.acf ),
		} ) )
		.sort( ( a, b ) => {
			if ( a.start !== b.start ) {
				return ( a.start ?? NO_YEAR ) - ( b.start ?? NO_YEAR );
			}
			return a.title.localeCompare( b.title );
		} );
}

function Timeline( { movements, places } ) {
	const [ activePlace, setActivePlace ] = useState( ALL );

	const placeNames = useMemo(
		() =>
			Object.fromEntries(
				places.map( ( place ) => [
					place.id,
					decodeEntities( place.name ),
				] )
			),
		[ places ]
	);

	const visible =
		activePlace === ALL
			? movements
			: movements.filter( ( movement ) =>
					movement.placeIds.includes( activePlace )
			  );

	return (
		<>
			<div
				className="atlas-timeline__filters"
				role="group"
				aria-label={ __( 'Filter by place', 'atlas' ) }
			>
				<button
					type="button"
					className="atlas-timeline__filter"
					aria-pressed={ activePlace === ALL }
					onClick={ () => setActivePlace( ALL ) }
				>
					{ __( 'All', 'atlas' ) }
				</button>
				{ places.map( ( place ) => (
					<button
						key={ place.id }
						type="button"
						className="atlas-timeline__filter"
						aria-pressed={ activePlace === place.id }
						onClick={ () => setActivePlace( place.id ) }
					>
						{ placeNames[ place.id ] }
					</button>
				) ) }
			</div>

			<p
				className="atlas-timeline__status"
				role="status"
				aria-live="polite"
			>
				{ sprintf(
					/* translators: %d: number of movements showing. */
					_n(
						'Showing %d movement',
						'Showing %d movements',
						visible.length,
						'atlas'
					),
					visible.length
				) }
			</p>

			<ol className="atlas-timeline__list">
				{ visible.map( ( movement ) => {
					const years = [ movement.start, movement.end ]
						.filter( ( year ) => year !== null )
						.join( '–' );
					const placeList = movement.placeIds
						.map( ( id ) => placeNames[ id ] )
						.filter( Boolean )
						.join( ', ' );

					return (
						<li
							key={ movement.id }
							className="atlas-timeline__item"
						>
							<a href={ movement.link }>{ movement.title }</a>
							{ years && (
								<span className="atlas-timeline__years">
									{ years }
								</span>
							) }
							{ placeList && (
								<span className="atlas-timeline__place">
									{ placeList }
								</span>
							) }
							{ movement.swatches.length > 0 && (
								<ul className="swatches">
									{ movement.swatches.map( ( swatch ) => (
										<li
											key={ swatch.number }
											className="swatch"
											style={ { '--swatch': swatch.color } }
										>
											<span className="screen-reader-text">
												{ sprintf(
													/* translators: 1: swatch number, 2: hex color. */
													__(
														'Swatch %1$d: %2$s',
														'atlas'
													),
													swatch.number,
													swatch.color
												) }
											</span>
										</li>
									) ) }
								</ul>
							) }
						</li>
					);
				} ) }
			</ol>
		</>
	);
}

function init( section ) {
	const { movementsUrl, placesUrl } = section.dataset;
	const fallback = section.querySelector( '.atlas-timeline__list' );

	if ( ! movementsUrl || ! placesUrl || ! fallback ) {
		return;
	}

	Promise.all( [ fetchJson( movementsUrl ), fetchJson( placesUrl ) ] )
		.then( ( [ movements, places ] ) => {
			const mount = document.createElement( 'div' );
			mount.className = 'atlas-timeline__app';

			createRoot( mount ).render(
				<Timeline movements={ prepare( movements ) } places={ places } />
			);
			fallback.replaceWith( mount );
		} )
		.catch( ( error ) => {
	// eslint-disable-next-line no-console
	console.error( 'atlas/timeline:', error );
	// The PHP-rendered list stays in place.
} );
}

document.querySelectorAll( '.atlas-timeline' ).forEach( init );
