# Sitegeist.Stampede 
## Svg Sprite Icons for Neos

The package creates svg sprites that combine multiple svgs into a single svg with symbols. To use the svg sprites 
a fusion prototype `Sitegeist.Stampede:Icon` is included that renders a symbol from a given svgspite.

The rendered html code for an icon will look in principle like this:
```html
<svg class="icon" style="fill: currentColor; height: 1em;">
    <use xlink:href="/stampede/svgsprite?collection=example#neos"></use>
</svg>
```

*Attention: This package use the external svg references which are not supported in some older browsers. Please 
check this and polyfills like this https://github.com/Keyamoon/svgxuse if needed.*

### Authors & Sponsors

* Wilhelm Behncke - behncke@sitegeist.de
* Martin Ficzel - ficzel@sitegeist.de

*The development and the public-releases of this package is generously sponsored by our employer https://www.sitegeist.de.*

## Configuration

The package manages icon collections that are defined via the Neos settings. It is possible to configure an 
collection from a `path` or by referenceing each `item` individually.

```yaml
Sitegeist:
  Stampede:
    collections:

      #
      # Collections with a path will include all svg files in the given path
      # The icon name and the label are created from the filename
      #
      example_one: 
        label: "Example One"
        path: resource://Vendor.Site/Private/Icons

      #
      # Collections with explicit items allow to configure the path and label
      # for each icon. The key defines the icon name.
      #
      example_two:
        label: "Example Two"
        items:
          foo:
            label: "Foo Item"
            path: resource://Vendor.Site/Private/Icons/foo.svg
          bar:
            label: "Bar Item"
            path: resource://Vendor.Site/Private/Icons/bar.svg
```

allow to select icons in a NodeType:
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

## Fusion

To render icons the prototype `Sitegeist.Stampede:Icon` is used via afx like this: 

```
    renderer = afx`
        <Sitegeist.Stampede:Icon identifier="__collectionName__:__iconName__" />
    `
```

ATTENTION: it is recommended to extend this prototype to your needs in your own fusion.

```
prototype(Vendow.Site:Component.SvgIcon) < prototype(Neos.Fusion:Component) {
    identifier = null

    renderer = Sitegeist.Stampede:Icon {
        identifier = ${props.identifier}
        class = "svgIcon"
        style = "enable-background:new 0 0 512 512;"
    }
}
```

Additionally the prototype `Sitegeist.Stampede:Icon.Preview` renders a list of all iconCollections 
as table to be viewed in the `Sitegeist.Monocle` styleguide.


## Installation

Sitegeist.Stampede is available via packagist. Just run `composer require sitegeist/stampede` to install it. We use semantic-versioning so every breaking change will increase the major-version number.

## Contribution

We will gladly accept contributions. Please send us pull requests.
