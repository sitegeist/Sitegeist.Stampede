# Sitegeist.Stampede 
## Svg Icons for Neos

The package renders icons based on svg files. The rendering is done inline or via an svg sprite that combines all svgs of a collection into one request.

*Attention: This package use the external svg references for svg-sprites which are not supported in some older browsers. Please check this and use polyfills like this https://github.com/Keyamoon/svgxuse if needed.*

### Authors & Sponsors

* Wilhelm Behncke - behncke@sitegeist.de
* Martin Ficzel - ficzel@sitegeist.de

*The development and the public-releases of this package is generously sponsored by our employer https://www.sitegeist.de.*

## Configuration

The package manages icon collections that are defined via Neos settings. It is possible to configure an 
collection from a `path` or by referenceing each `item` individually.

```yaml
Sitegeist:
  Stampede:
    collections:

      #
      # Collections with a path will include all svg files in the given path
      # The icon name and the label are created from the filename
      #
      default: 
        label: "Default Collection"
        path: resource://Vendor.Site/Private/Icons

      #
      # Collections with explicit items allow to configure the path and label
      # for each icon. The key defines the icon name.
      #
      example:
        label: "Example Collection"
        items:
          foo:
            label: "Foo Item"
            path: resource://Vendor.Site/Private/Icons/foo.svg
          bar:
            label: "Bar Item"
            path: resource://Vendor.Site/Private/Icons/bar.svg
```

The generated svg sprites are cached for each collection in Production context. For the Development context
the sprite cache is disabled. You can control this via setting:

```yaml
Sitegeist:
  Stampede:
    enableCache: false
```  

The svg sprite sheet will get a cache-control header in Production context. You can adjust the value or disable this
via setting:

```yaml
Sitegeist:
  Stampede:
      publicCacheLifetime: 86400
```  

A custom data source is included to allow editors to select icons in the Neos Inspector: 
```yaml
'Vendor.Site:NodeType': 
  properties:
    icon:
      type: string
      ui:
        inspector:
          editor: 'Neos.Neos/Inspector/Editors/SelectBoxEditor'
          editorOptions:
            dataSourceIdentifier: 'sitegeist-stampede-icons'
            dataSourceAdditionalData:
              # Optionaly the icon collections offered to the editor
              # can be configured. By default all collections will be available   
              collections: ['example']
```

### Mixins, Presets, Silhouettes

The package contains the Mixin `Sitegeist.Silhouette:Mixin.Icon` and the property-preset / silhouette `stampede.icon`.

## Fusion

`Sitegeist.Stampede:Icon` has the following options:
`identifier`: string (required) combined identifier of `collection` and `icon` separated by a `colon`. Will override `collection` and `icon` values
`collection`: string (deprecated, use `identifier` in future) name of the icon collection
`icon`: string (deprecated, use `identifier` in future) name of the icon 
`class`: string (optional) class to add to the svg tag
`style`: string (optional) style to add to the svg tag. Default is `fill: currentColor; height: 1em;`
`inline`: boolean render the svg inline. Default is `false`

To render icons the prototype `Sitegeist.Stampede:Icon` is used via afx like this. 

```neosfusion
    renderer = afx`
        <Sitegeist.Stampede:Icon identifier="default:neos" />
    `
```

If the `inline` option is set the svg content is directly put into the html instead of referencing
the spritesheet. This can improve the performance if many icons exist but only very few are used on a single page. 

```neosfusion
    renderer = afx`
        <Sitegeist.Stampede:Icon identifier="default:neos" inline />
    `
```

ATTENTION: It is highly recommended to create a wrapper prototype for icons that sets the required `class` and unsets the default `style`.

```neosfusion
prototype(Vendor.Site:Component.SvgIcon) < prototype(Neos.Fusion:Component) {
    identifier = null

    renderer = Sitegeist.Stampede:Icon {
        identifier = ${props.identifier}
        icon = ${props.icon}
        class = "svgIcon"
        style = null
    }
}
```

Additionally the prototype `Sitegeist.Stampede:Icon.Preview` renders a list of all iconCollections 
as table to be viewed in the `Sitegeist.Monocle` styleguide.


## Installation

Sitegeist.Stampede is available via packagist. Just run `composer require sitegeist/stampede` to install it. We use semantic-versioning so every breaking change will increase the major-version number.

## Contribution

We will gladly accept contributions. Please send us pull requests.
