<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:param name="scriptapp">oompah/</xsl:param>
	<xsl:param name="scriptappname">loompah.js</xsl:param>
	<xsl:template match="/">
		<xsl:apply-templates select="script" />
		<xsl:apply-templates select="@*|node()" />
	</xsl:template>

	<xsl:attribute-set name="script">
		<xsl:attribute name="type">
			<xsl:text>text/javascript</xsl:text>
		</xsl:attribute>
		<xsl:attribute name="src">
			<xsl:value-of select="$scriptapp" /><xsl:value-of select="$scriptappname" />
		</xsl:attribute>
	</xsl:attribute-set>

	<xsl:template match="script">
		<xsl:element name="script" use-attribute-sets="script" />
	</xsl:template>

	<xsl:template match="@*|node()">
		<xsl:copy>
			<xsl:apply-templates select="@*|node()" />
		</xsl:copy>
	</xsl:template>

	<xsl:output
		method="xml"
		indent="yes"
	/>
</xsl:stylesheet>
